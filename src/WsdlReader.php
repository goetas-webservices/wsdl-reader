<?php
namespace Goetas\XML\WSDLReader;

use DOMDocument;
use DOMElement;
use Goetas\XML\WSDLReader\Wsdl\Definitions;
use Goetas\XML\WSDLReader\Utils\UrlUtils;
use Goetas\XML\WSDLReader\Wsdl\Message;
use Goetas\XML\WSDLReader\Wsdl\PortType;
use Goetas\XML\WSDLReader\Wsdl\Operation;
use Goetas\XML\WSDLReader\Wsdl\Param;
use Goetas\XML\WSDLReader\Wsdl\Fault;
use Goetas\XML\WSDLReader\Wsdl\Service;
use Goetas\XML\WSDLReader\Wsdl\Binding;
use Goetas\XML\WSDLReader\Wsdl\BindingOperation;
use Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage;
use Goetas\XML\WSDLReader\Wsdl\BindingOperationFault;
use Goetas\XML\WSDLReader\Wsdl\Part;
use Goetas\XML\WSDLReader\Wsdl\Port;
use Goetas\XML\XSDReader\Schema\Schema;
use Goetas\XML\XSDReader\SchemaReader;

class WsdlReader
{

    const WSDL_NS = "http://schemas.xmlsoap.org/wsdl/";

    const XSD_NS = "http://www.w3.org/2001/XMLSchema";

    private $loadedFiles = array();

    public function __construct()
    {
    }

    /**
     *
     * @param DOMElement $node
     * @return string
     */
    private function getDocumentation(DOMElement $node)
    {
        $doc = '';
        foreach ($node->childNodes as $childNode) {
            if ($childNode->localName == "documentation") {
                $doc .= ($childNode->nodeValue);
            }
        }
        return $doc;
    }

    /**
     *
     * @param Definitions $definitions
     * @param DOMElement $node
     * @param Definitions $parent
     * @return array
     */
    private function rootNode(Definitions $definitions, DOMElement $node, Definitions $parent = null)
    {
        $definitions->setDocumentation($this->getDocumentation($node));

        if ($node->hasAttribute("targetNamespace")) {
            $definitions->setTargetNamespace($node->getAttribute("targetNamespace"));
        }

        $functions = array();
        foreach ($node->childNodes as $childNode) {
            if (! ($childNode instanceof DOMElement) || $childNode->namespaceURI !== self::WSDL_NS) {
                continue;
            }

            switch ($childNode->localName) {
                case 'import':
                    $functions[] = $this->loadImport($definitions, $childNode);
                    break;
                case 'types':
                    $this->loadTypes($definitions, $childNode);
                    break;
                case 'message':
                    $functions[] = $this->loadMessage($definitions, $childNode);
                    break;
                case 'portType':
                    $functions[] = $this->loadPortType($definitions, $childNode);
                    break;
                case 'binding':
                    $functions[] = $this->loadBinding($definitions, $childNode);
                    break;
                case 'service':
                    $functions[] = $this->loadService($definitions, $childNode);
                    break;
            }
        }

        return $functions;
    }

    public function loadTypes(Definitions $definitions, \DOMElement $node)
    {
        foreach ($node->childNodes as $k => $childNode) {
            if (($childNode instanceof \DOMElement) && $childNode->namespaceURI === self::XSD_NS && $childNode->localName == 'schema') {
                $reader = new SchemaReader();
                $schema = $reader->readNode($node, $childNode->ownerDocument->documentURI . "#" . $k);
                $definitions->getSchema()->addSchema($schema);
            }
        }
    }

    private function loadBinding(Definitions $definitions, DOMElement $node)
    {
        $binding = new Binding($definitions, $node->getAttribute("name"));
        $binding->setDocumentation($this->getDocumentation($node));
        $definitions->addBinding($binding);

        $functions = array();
        foreach ($node->childNodes as $childNode) {
            if (! ($childNode instanceof DOMElement) || $childNode->namespaceURI !== self::WSDL_NS) {
                continue;
            }
            switch ($childNode->localName) {
                case 'operation':
                    $functions[] = $this->loadBindingOperation($binding, $childNode);
                    break;
            }
        }
        return function () use($functions, $binding, $definitions, $node)
        {
            list ($name, $ns) = WsdlReader::splitParts($node, $node->getAttribute("type"));
            $binding->setType($definitions->findPortType($name, $ns));
            foreach ($functions as $function) {
                call_user_func($function);
            }
        };
    }

    private function loadBindingOperation(Binding $binding, DOMElement $node)
    {
        $bindingOperation = new BindingOperation($binding, $node->getAttribute("name"));
        $bindingOperation->setDocumentation($this->getDocumentation($node));

        $binding->addOperation($bindingOperation);

        $functions = array();
        foreach ($node->childNodes as $childNode) {
            if (! ($childNode instanceof DOMElement) || $childNode->namespaceURI !== self::WSDL_NS) {
                continue;
            }
            switch ($childNode->localName) {
                case 'input':
                    $functions[] = $this->loadBindingOperationMessage($bindingOperation, $childNode);
                    break;
                case 'output':
                    $functions[] = $this->loadBindingOperationMessage($bindingOperation, $childNode);
                    break;
                case 'fault':
                    $functions[] = $this->loadBindingOperationFault($bindingOperation, $childNode);
                    break;
            }
        }
        return function () use($functions)
        {
            foreach ($functions as $function) {
                call_user_func($function);
            }
        };
    }

    private function loadBindingOperationMessage(BindingOperation $bindingOperation, DOMElement $node)
    {
        $message = new BindingOperationMessage($bindingOperation, $node->getAttribute("name"));
        $message->setDocumentation($this->getDocumentation($node));
        $bindingOperation->setInput($message);

        return function ()
        {
        };
    }

    private function loadBindingOperationFault(BindingOperation $bindingOperation, DOMElement $node)
    {
        $message = new BindingOperationFault($bindingOperation, $node->getAttribute("name"));
        $message->setDocumentation($this->getDocumentation($node));
        $bindingOperation->setInput($message);
        return function ()
        {
        };
    }

    private function loadService(Definitions $definitions, DOMElement $node)
    {
        $service = new Service($definitions, $node->getAttribute("name"));
        $service->setDocumentation($this->getDocumentation($node));
        $definitions->addService($service);

        $functions = array();
        foreach ($node->childNodes as $childNode) {
            if (! ($childNode instanceof DOMElement) || $childNode->namespaceURI !== self::WSDL_NS) {
                continue;
            }
            switch ($childNode->localName) {
                case 'port':
                    $functions[] = $this->loadPort($service, $childNode);
                    break;
            }
        }
        return function () use($functions)
        {
            foreach ($functions as $function) {
                call_user_func($function);
            }
        };
    }

    private function loadMessage(Definitions $definitions, DOMElement $node)
    {
        $message = new Message($definitions, $node->getAttribute("name"));
        $message->setDocumentation($this->getDocumentation($node));
        $definitions->addMessage($message);

        return function () use($node, $message)
        {
            foreach ($node->childNodes as $childNode) {
                if (! ($childNode instanceof DOMElement) || $childNode->namespaceURI !== self::WSDL_NS) {
                    continue;
                }
                switch ($childNode->localName) {
                    case 'part':
                        call_user_func($this->loadMessagePart($message, $childNode));
                        break;
                }
            }
        };
    }

    private function loadPort(Service $service, DOMElement $node)
    {
        $port = new Port($service, $node->getAttribute("name"));
        $port->setDocumentation($this->getDocumentation($node));
        $service->addPort($port);

        return function () use($port, $service, $node)
        {
            list ($name, $ns) = WsdlReader::splitParts($node, $node->getAttribute("binding"));
            $port->setBinding($service->getDefinition()->findBinding($name, $ns));
        };
    }

    private function loadPortType(Definitions $definitions, DOMElement $node)
    {
        $port = new PortType($definitions, $node->getAttribute("name"));
        $port->setDocumentation($this->getDocumentation($node));
        $definitions->addPortType($port);

        $functions = array();
        foreach ($node->childNodes as $childNode) {
            if (! ($childNode instanceof DOMElement) || $childNode->namespaceURI !== self::WSDL_NS) {
                continue;
            }
            switch ($childNode->localName) {
                case 'operation':
                    $functions[] = $this->loadPortTypeOperation($port, $childNode);
                    break;
            }
        }
        return function () use($functions)
        {
            foreach ($functions as $function) {
                call_user_func($function);
            }
        };
    }

    private function loadPortTypeOperation(PortType $port, DOMElement $node)
    {
        $operation = new Operation($port, $node->getAttribute("name"));
        $operation->setDocumentation($this->getDocumentation($node));
        $operation->setParameterOrder($node->getAttribute("parameterOrder") ?  : null);

        $port->addOperation($operation);
        $functions = array();
        foreach ($node->childNodes as $childNode) {
            if (! ($childNode instanceof DOMElement) || $childNode->namespaceURI !== self::WSDL_NS) {
                continue;
            }
            switch ($childNode->localName) {
                case 'input':
                    $functions[] = $this->loadParam($operation, $childNode, true);
                    break;
                case 'output':
                    $functions[] = $this->loadParam($operation, $childNode, false);
                    break;
                case 'fault':
                    $functions[] = $this->loadFault($operation, $childNode);
                    break;
            }
        }
        return function () use($functions)
        {
            foreach ($functions as $function) {
                call_user_func($function);
            }
        };
    }

    private function loadParam(Operation $operation, DOMElement $node, $in = true)
    {
        $param = new Param($operation, $node->getAttribute("name"));
        $param->setDocumentation($this->getDocumentation($node));

        if ($in) {
            $operation->setInput($param);
        } else {
            $operation->setOutput($param);
        }

        return function () use($param, $operation, $node)
        {
            list ($name, $ns) = WsdlReader::splitParts($node, $node->getAttribute("message"));
            $param->setMessage($operation->getDefinition()->findMessage($name, $ns));
        };
    }

    private function loadFault(Operation $operation, DOMElement $node)
    {
        $fault = new Fault($operation, $node->getAttribute("name"));
        $fault->setDocumentation($this->getDocumentation($node));
        $operation->setFault($fault);
        return function () use($param, $operation, $node)
        {
            list ($name, $ns) = WsdlReader::splitParts($node, $node->getAttribute("message"));
            $param->setMessage($operation->getDefinition()->findMessage($name, $ns));
        };
    }

    private function loadMessagePart(Message $message, DOMElement $node)
    {
        $part = new Part($message, $node->getAttribute("name"));
        $part->setDocumentation($this->getDocumentation($node));
        $message->addPart($part);

        return function () use($part, $node)
        {
            return;
            if ($node->hasAttribute("element")) {
                $part->setType($this->findElement($message->getDefinitions(), $node->hasAttribute("element")));
            } elseif ($node->getAttribute("type")) {
                $part->setElement($this->findType($message->getDefinitions(), $node->hasAttribute("type")));
            }
        };
    }

    private function loadOperation(Definitions $definitions, DOMElement $node)
    {
        $attribute = new Operation($definitions);
        $attribute->setDocumentation($this->getDocumentation($node));

        return $attribute;
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

    private function loadImport(Definitions $definitions, DOMElement $node)
    {
        $file = UrlUtils::resolveRelativeUrl($node->ownerDocument->documentURI, $node->getAttribute("location"));
        if (isset($this->loadedFiles[$file])) {
            $definitions->addDefinitions($this->loadedFiles[$file]);
            return function ()
            {
            };
        }

        if (! $node->getAttribute("namespace")) {
            $this->loadedFiles[$file] = $newDefinitions = $definitions;
        } else {
            $this->loadedFiles[$file] = $newDefinitions = new Definitions($file);
        }

        $xml = $this->getDOM($file);

        $callbacks = $this->rootNode($newDefinitions, $xml->documentElement, $definitions);

        if ($node->getAttribute("namespace")) {
            $definitions->addImport($newDefinitions);
        }

        return function () use($callbacks)
        {
            foreach ($callbacks as $callback) {
                call_user_func($callback);
            }
        };
    }

    /**
     *
     * @return \Goetas\XML\XSDReader\Wsdl\Definitions
     */
    public function readNode(\DOMNode $node, $file = 'wsdl.xsd')
    {
        $this->loadedFiles[$file] = $rootDefinitions = new Definitions($file);

        $callbacks = $this->rootNode($rootDefinitions, $node);

        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }

        return $rootDefinitions;
    }

    /**
     *
     * @return \Goetas\XML\XSDReader\Wsdl\Definitions
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
     *
     * @return \Goetas\XML\XSDReader\Wsdl\Definitions
     */
    public function readFile($file)
    {
        $xml = $this->getDOM($file);
        return $this->readNode($xml->documentElement, $file);
    }

    /**
     *
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