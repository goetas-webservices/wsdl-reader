<?php
namespace Goetas\XML\WSDLReader;

use Goetas\XML\WSDLReader\Wsdl\Wsdl;
use Goetas\XML\WSDLReader\Wsdl\utils\UrlUtils;
use Goetas\XML\WSDLReader\Wsdl\Message;
use Goetas\XML\WSDLReader\Wsdl\MessagePart;
use Goetas\XML\WSDLReader\Wsdl\PortType;
use Goetas\XML\WSDLReader\Wsdl\Operation;
class WsdlReader
{
	const WSDL_NS = "hhttp://wsdls.xmlsoap.org/wsdl";

    const XSD_NS = "http://www.w3.org/2001/XMLWsdl";

    const XML_NS = "http://www.w3.org/XML/1998/namespace";

    private $loadedFiles = array();

    public function __construct()
    {

    }

    private function loadAttributeGroup(Wsdl $wsdl, DOMElement $node)
    {
        $attGroup = new AttributeGroup($wsdl, $node->getAttribute("name"));
        $attGroup->setDoc($this->getDocumentation($node));
        $wsdl->addAttributeGroup($attGroup);

        return function () use($wsdl, $node, $attGroup)
        {
            foreach ($node->childNodes as $childNode) {
                switch ($childNode->localName) {
                    case 'attribute':
                        if ($childNode->hasAttribute("ref")) {
                            $attribute = $this->findSomething('findAttribute', $wsdl, $node, $childNode->getAttribute("ref"));
                        } else {
                            $attribute = $this->loadAttribute($wsdl, $childNode);
                        }
                        $attGroup->addAttribute($attribute);
                        break;
                    case 'attributeGroup':

                        $attribute = $this->findSomething('findAttributeGroup', $wsdl, $node, $childNode->getAttribute("ref"));
                        $attGroup->addAttribute($attribute);
                        break;
                }
            }
        };
    }

    private function loadAttribute(Wsdl $wsdl, DOMElement $node)
    {
        $attribute = new Attribute($wsdl, $node->getAttribute("name"));
        $attribute->setDoc($this->getDocumentation($node));
        $this->fillItem($attribute, $node);

        if ($node->hasAttribute("nillable")) {
            $attribute->setNil($node->getAttribute("nillable") == "true");
        }
        if ($node->hasAttribute("form")) {
            $attribute->setQualified($node->getAttribute("form") == "qualified");
        }
        if ($node->hasAttribute("use")) {
            $attribute->setUse($node->getAttribute("use"));
        }
        return $attribute;
    }


    private function loadAttributeDef(Wsdl $wsdl, DOMElement $node)
    {
        $attribute = new AttributeDef($wsdl, $node->getAttribute("name"));

        $wsdl->addAttribute($attribute);

        return function () use($attribute, $wsdl, $node)
        {
            $this->fillItem($attribute, $node);
        };
    }

    /**
     * @param DOMElement $node
     * @return string
     */
    private function getDocumentation(DOMElement $node)
    {
        $doc = '';
        foreach ($node->childNodes as $childNode) {
            if ($childNode->localName == "annotation") {
                foreach ($childNode->childNodes as $subChildNode) {
                    if ($subChildNode->localName == "documentation") {
                        $doc .= ($subChildNode->nodeValue);
                    }
                }
            }
        }
        return $doc;
    }

    /**
     *
     * @param Wsdl $wsdl
     * @param DOMElement $node
     * @param Wsdl $parent
     * @return array
     */
    private function rootNode(Wsdl $wsdl, DOMElement $node, Wsdl $parent = null)
    {
        $wsdl->setDoc($this->getDocumentation($node));

        if ($node->hasAttribute("targetNamespace")) {
            $wsdl->setTargetNamespace($node->getAttribute("targetNamespace"));
        }

        $functions = array();
        foreach ($node->childNodes as $childNode) {
            switch ($childNode->localName) {
                case 'import':
                    $functions[] = $this->loadImport($wsdl, $childNode);
                    break;
                case 'types':
                    $functions[] = $this->loadTypes($wsdl, $childNode);
                    break;
                case 'message':
                    $functions[] = $this->loadMessage($wsdl, $childNode);
                    break;
                case 'portType':
                    $functions[] = $this->loadPortType($wsdl, $childNode);
                    break;
                case 'binding':
                    $functions[] = $this->loadBinding($wsdl, $childNode);
                    break;
                case 'service':
                    $functions[] = $this->loadService($wsdl, $childNode);
                    break;
            }
        }

        return $functions;
    }

    private function loadMessage(Wsdl $wsdl, DOMElement $node)
    {
        $message = new Message($wsdl, $node->getAttribute("name"));
        $message->setDoc($this->getDocumentation($node));

        foreach ($node->childNodes as $childNode) {
            switch ($childNode->localName) {
                case 'part':
                    $part = $this->loadMessagePart($wsdl, $childNode);
                    $message->addPart($part);
                    break;
            }
        }
        return $message;
    }

    private function loadMessagePart(Wsdl $wsdl, DOMElement $node)
    {
        $message = new MessagePart($wsdl, $node->getAttribute("name"));
        $message->setDoc($this->getDocumentation($node));
        // @todo @element|@type
        return $message;
    }

    private function loadPortType(Wsdl $wsdl, DOMElement $node)
    {
        $port = new PortType($wsdl, $node->getAttribute("name"));
        $port->setDoc($this->getDocumentation($node));

        foreach ($node->childNodes as $childNode) {
            switch ($childNode->localName) {
                case 'operation':
                    $operation = $this->loadOperation($wsdl, $childNode);
                    $port->addOperation($operation);
                    break;
            }
        }
        return $port;
    }

    private function loadOperation(Wsdl $wsdl, DOMElement $node)
    {
        $attribute = new Operation($wsdl);
        $attribute->setDoc($this->getDocumentation($node));

        return $attribute;
    }


    private function loadSimpleType(Wsdl $wsdl, DOMElement $node, $callback = null)
    {
        $type = new SimpleType($wsdl, $node->getAttribute("name"));
        $type->setDoc($this->getDocumentation($node));
        if ($node->getAttribute("name")) {
            $wsdl->addType($type);
        }

        return function () use($type, $node, $callback)
        {
            $this->fillTypeNode($type, $node);

            foreach ($node->childNodes as $childNode) {
                switch ($childNode->localName) {
                    case 'union':
                        $this->loadUnion($type, $childNode);
                        break;
                }
            }

            if ($callback) {
                call_user_func($callback, $type);
            }
        };
    }

    private static function splitParts(DOMElement $node, $typeName)
    {
        $namespace = null;
        $prefix = null;
        $name = $typeName;
        if (strpos($typeName, ':') !== false) {
            list ($prefix, $name) = explode(':', $typeName);
            $namespace = $node->lookupNamespaceURI($prefix);
        }
        return array(
            $name,
            $namespace,
            $prefix
        );
    }

    private function loadElementDef(Wsdl $wsdl, DOMElement $node)
    {
        $element = new ElementDef($wsdl, $node->getAttribute("name"));
        $wsdl->addElement($element);

        return function () use ($element, $node) {
            $this->fillItem($element, $node);
        };
    }

    private function loadImport(Wsdl $wsdl, DOMElement $node)
    {
        $file = UrlUtils::resolveRelativeUrl($node->ownerDocument->documentURI, $node->getAttribute("wsdlLocation"));
        if ($node->hasAttribute("namespace") && in_array($node->getAttribute("namespace"), array_keys(self::$globalWsdlInfo), true)){
            return function ()
            {
            };
        }elseif (isset($this->loadedFiles[$file])) {
            $wsdl->addWsdl($this->loadedFiles[$file]);
            return function () {
            };
        }

        if (!$node->getAttribute("namespace")){
            $this->loadedFiles[$file] = $newWsdl = $wsdl;
        }else{
            $this->loadedFiles[$file] = $newWsdl = new Wsdl($file);
        }

        $xml = $this->getDOM($file);

        $callbacks = $this->rootNode($newWsdl, $xml->documentElement, $wsdl);

        if ($node->getAttribute("namespace")){
            $wsdl->addWsdl($newWsdl);
        }

        return function () use($callbacks)
        {
            foreach ($callbacks as $callback) {
                call_user_func($callback);
            }
        };
    }


    /**
     * @return \Goetas\XML\XSDReader\Wsdl\Wsdl
     */
    public function readNode(\DOMNode $node, $file = 'wsdl.xsd')
    {
        $this->loadedFiles[$file] = $rootWsdl = new Wsdl($file);

        $this->addGlobalWsdls($rootWsdl);
        $callbacks = $this->rootNode($rootWsdl, $node);

        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }

        return $rootWsdl;
    }


    /**
     * @return \Goetas\XML\XSDReader\Wsdl\Wsdl
     */
    public function readString($content, $file = 'wsdl.xsd')
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        if (! $xml->loadXML($content)) {
            throw new IOException("Can't load the wsdl");
        }
        $xml->documentURI = $file;

        return $this->readNode($xml->documentElement, $file);
    }
    /**
     * @return \Goetas\XML\XSDReader\Wsdl\Wsdl
     */
    public function readFile($file)
    {
        $xml = $this->getDOM($file);
        return $this->readNode($xml->documentElement, $file);
    }

    /**
     * @param string $file
     * @throws IOException
     * @return \DOMDocument
     */
    private function getDOM($file)
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        if (! $xml->load($file)) {
            throw new IOException("Can't load the file $file");
        }
        return $xml;
    }
}