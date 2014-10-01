<?php
namespace Goetas\XML\WSDLReader;

use Goetas\XML\WSDLReader\Wsdl\Wsdl;
class WsdlReader
{
	const WSDL_NS = "hhttp://wsdls.xmlsoap.org/wsdl";

    const XSD_NS = "http://www.w3.org/2001/XMLWsdl";

    const XML_NS = "http://www.w3.org/XML/1998/namespace";

    private $loadedFiles = array();

    private static $globalWsdlInfo = array(
        self::XML_NS => 'http://www.w3.org/2001/xml.xsd',
        self::XSD_NS => 'http://www.w3.org/2001/XMLWsdl.xsd'
    );

    public function __construct()
    {
        $this->addKnownWsdlLocation('http://www.w3.org/2001/xml.xsd', __DIR__ . '/Resources/xml.xsd');
        $this->addKnownWsdlLocation('http://www.w3.org/2001/XMLWsdl.xsd', __DIR__ . '/Resources/XMLWsdl.xsd');
    }

    public function addKnownWsdlLocation($remote, $local)
    {
        $this->knowLocationWsdls[$remote] = $local;
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

    private function loadElement(Wsdl $wsdl, DOMElement $node)
    {
        $element = new Element($wsdl, $node->getAttribute("name"));
        $element->setDoc($this->getDocumentation($node));

        $this->fillItem($element, $node);

        if ($node->hasAttribute("maxOccurs")) {
            $element->setMax($node->getAttribute("maxOccurs") == "unbounded" ? - 1 : (int)$node->getAttribute("maxOccurs"));
        }
        if ($node->hasAttribute("minOccurs")) {
            $element->setMin((int)$node->getAttribute("minOccurs"));
        }
        if ($node->hasAttribute("nillable")) {
            $element->setNil($node->getAttribute("nillable") == "true");
        }
        if ($node->hasAttribute("form")) {
            $element->setQualified($node->getAttribute("form") == "qualified");
        }
        return $element;
    }

    private function loadElementRef(ElementDef $referencedElement, DOMElement $node)
    {
        $element = new ElementRef($referencedElement);
        $element->setDoc($this->getDocumentation($node));

        if ($node->hasAttribute("maxOccurs")) {
            $element->setMax($node->getAttribute("maxOccurs") == "unbounded" ? - 1 : (int)$node->getAttribute("maxOccurs"));
        }
        if ($node->hasAttribute("minOccurs")) {
            $element->setMin((int)$node->getAttribute("minOccurs"));
        }
        if ($node->hasAttribute("nillable")) {
            $element->setNil($node->getAttribute("nillable") == "true");
        }
        if ($node->hasAttribute("form")) {
            $element->setQualified($node->getAttribute("form") == "qualified");
        }

        return $element;
    }


    private function loadAttributeRef(AttributeDef $referencedAttribiute, DOMElement $node)
    {
        $attribute = new AttributeRef($referencedAttribiute);
        $attribute->setDoc($this->getDocumentation($node));

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

    private function loadSequence(ElementContainer $elementContainer, DOMElement $node)
    {
        foreach ($node->childNodes as $childNode) {

            switch ($childNode->localName) {
                case 'element':
                    if ($childNode->hasAttribute("ref")) {
                        $referencedElement = $this->findSomething('findElement', $elementContainer->getWsdl(), $node, $childNode->getAttribute("ref"));
                        $element = $this->loadElementRef($referencedElement, $childNode);
                    } else {
                        $element = $this->loadElement($elementContainer->getWsdl(), $childNode);
                    }
                    $elementContainer->addElement($element);
                    break;
                case 'group':
                    $element = $this->findSomething('findGroup', $elementContainer->getWsdl(), $node, $childNode->getAttribute("ref"));
                    $elementContainer->addElement($element);
                    break;
            }
        }
    }

    private function loadGroup(Wsdl $wsdl, DOMElement $node)
    {
        $type = new Group($wsdl, $node->getAttribute("name"));
        $type->setDoc($this->getDocumentation($node));
        $wsdl->addGroup($type);

        return function () use($type, $node)
        {
            foreach ($node->childNodes as $childNode) {
                switch ($childNode->localName) {
                    case 'sequence':
                    case 'choice':
                        $this->loadSequence($type, $childNode);
                        break;
                }
            }
        };
    }

    private function loadComplexType(Wsdl $wsdl, DOMElement $node, $callback = null)
    {
        $isSimple = false;

        foreach ($node->childNodes as $childNode) {
            if ($childNode->localName === "simpleContent") {
                $isSimple = true;
                break;
            }
        }

        $type = $isSimple ? new ComplexTypeSimpleContent($wsdl, $node->getAttribute("name")) : new ComplexType($wsdl, $node->getAttribute("name"));

        $type->setDoc($this->getDocumentation($node));
        if ($node->getAttribute("name")) {
            $wsdl->addType($type);
        }

        return function () use($type, $node, $wsdl, $callback)
        {

            $this->fillTypeNode($type, $node);

            foreach ($node->childNodes as $childNode) {
                switch ($childNode->localName) {
                    case 'sequence':
                    case 'choice':
                        $this->loadSequence($type, $childNode);
                        break;
                    case 'attribute':
                        if ($childNode->hasAttribute("ref")) {
                            $referencedAttribute = $this->findSomething('findAttribute', $wsdl, $node, $childNode->getAttribute("ref"));
                            $attribute = $this->loadAttributeRef($referencedAttribute, $childNode);
                        } else {
                            $attribute = $this->loadAttribute($wsdl, $childNode);
                        }

                        $type->addAttribute($attribute);
                        break;
                    case 'attributeGroup':
                        $attribute = $this->findSomething('findAttributeGroup', $wsdl, $node, $childNode->getAttribute("ref"));
                        $type->addAttribute($attribute);
                        break;
                }
            }

            if ($callback) {
                call_user_func($callback, $type);
            }
        };
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

    private function loadUnion(SimpleType $type, DOMElement $node)
    {
        if ($node->hasAttribute("memberTypes")) {
            $types = preg_split('/\s+/', $node->getAttribute("memberTypes"));
            foreach ($types as $typeName) {
                $type->addUnion($this->findSomething('findType', $type->getWsdl(), $node, $typeName));
            }
        }
        $addCallback = function ($unType) use($type)
        {
            $type->addUnion($unType);
        };

        foreach ($node->childNodes as $childNode) {
            switch ($childNode->localName) {
                case 'simpleType':
                    call_user_func($this->loadSimpleType($type->getWsdl(), $childNode, $addCallback));
                    break;
            }
        }
    }

    private function fillTypeNode(Type $type, DOMElement $node)
    {
        foreach ($node->childNodes as $childNode) {
            switch ($childNode->localName) {
                case 'restriction':
                    $this->loadRestriction($type, $childNode);
                    break;
                case 'extension':
                    $this->loadExtension($type, $childNode);
                    break;
                case 'simpleContent':
                case 'complexContent':
                    $this->fillTypeNode($type, $childNode);
                    break;
            }
        }
    }

    private function loadExtension(BaseComplexType $type, DOMElement $node)
    {
        $extension = new Extension();
        $type->setExtension($extension);

        if ($node->hasAttribute("base")) {
            $parent = $this->findSomething('findType', $type->getWsdl(), $node, $node->getAttribute("base"));
            $extension->setBase($parent);
        }

        foreach ($node->childNodes as $childNode) {
            switch ($childNode->localName) {
                case 'sequence':
                case 'choice':
                    $this->loadSequence($type, $childNode);
                    break;
                case 'attribute':
                    if ($childNode->hasAttribute("ref")) {
                        $attribute = $this->findSomething('findAttribute', $type->getWsdl(), $node, $childNode->getAttribute("ref"));
                    } else {
                        $attribute = $this->loadAttribute($type->getWsdl(), $childNode);
                    }
                    $type->addAttribute($attribute);
                    break;
                case 'attributeGroup':
                    $attribute = $this->findSomething('findAttributeGroup', $type->getWsdl(), $node, $childNode->getAttribute("ref"));
                    $type->addAttribute($attribute);
                    break;
            }
        }
    }

    private function loadRestriction(Type $type, DOMElement $node)
    {
        $restriction = new Restriction();
        $type->setRestriction($restriction);
        if ($node->hasAttribute("base")) {
            $restrictedType = $this->findSomething('findType', $type->getWsdl(), $node, $node->getAttribute("base"));
            $restriction->setBase($restrictedType);
        } else {
            $addCallback = function ($restType) use($restriction)
            {
                $restriction->setBase($restType);
            };

            foreach ($node->childNodes as $childNode) {
                switch ($childNode->localName) {
                    case 'simpleType':
                        call_user_func($this->loadSimpleType($type->getWsdl(), $childNode, $addCallback));
                        break;
                }
            }
        }
        foreach ($node->childNodes as $childNode) {
            if (in_array($childNode->localName,
                [
                    'enumeration',
                    'pattern',
                    'length',
                    'minLength',
                    'maxLength',
                    'minInclusve',
                    'maxInclusve',
                    'minExclusve',
                    'maxEXclusve'
                ], true)) {
                $restriction->addCheck($childNode->localName,
                    [
                        'value' => $childNode->getAttribute("value"),
                        'doc' => $this->getDocumentation($childNode)
                    ]);
            }
        }
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

    /**
     *
     * @param string $finder
     * @param Wsdl $wsdl
     * @param DOMElement $node
     * @param string $typeName
     * @throws TypeException
     * @return ElementItem|Group|AttributeItem|AttribiuteGroup|Type
     */
    private function findSomething($finder, Wsdl $wsdl, DOMElement $node, $typeName)
    {
        list ($name, $namespace) = self::splitParts($node, $typeName);

        $namespace = $namespace ?: $wsdl->getTargetNamespace();

        try {
            return $wsdl->$finder($name, $namespace);
        } catch (TypeNotFoundException $e) {
            throw new TypeException(sprintf("Can't find %s named {%s}#%s, at line %d in %s ", strtolower(substr($finder, 4)), $namespace, $name, $node->getLineNo(), $node->ownerDocument->documentURI), 0, $e);
        }
    }

    private function loadElementDef(Wsdl $wsdl, DOMElement $node)
    {
        $element = new ElementDef($wsdl, $node->getAttribute("name"));
        $wsdl->addElement($element);

        return function () use ($element, $node) {
            $this->fillItem($element, $node);
        };
    }

    private function fillItem(Item $element, DOMElement $node)
    {
        $element->setIsAnonymousType(! $node->hasAttribute("type"));

        if ($element->isAnonymousType()) {

            $addCallback = function ($type) use($element) {
                $element->setType($type);
            };
            foreach ($node->childNodes as $childNode) {
                switch ($childNode->localName) {
                    case 'complexType':
                        call_user_func($this->loadComplexType($element->getWsdl(), $childNode, $addCallback));
                        break;
                    case 'simpleType':
                        call_user_func($this->loadSimpleType($element->getWsdl(), $childNode, $addCallback));
                        break;
                }
            }
        } else {
            $type = $this->findSomething('findType', $element->getWsdl(), $node, $node->getAttribute("type"));
            $element->setType($type);
        }
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



        foreach ($this->globalWsdls as $globaWsdlNS => $globaWsdl) {
            $newWsdl->addWsdl($globaWsdl, $globaWsdlNS);
        }

        $xml = $this->getDOM(isset($this->knowLocationWsdls[$file])?$this->knowLocationWsdls[$file]:$file);


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

    private function addGlobalWsdls(Wsdl $rootWsdl)
    {
        if (! $this->globalWsdls) {

            $callbacks = array();
            foreach (self::$globalWsdlInfo as $namespace => $uri) {
                $this->globalWsdls[$namespace] = $wsdl = new Wsdl($uri);

                $xml = $this->getDOM($this->knowLocationWsdls[$uri]);
                $callbacks = array_merge($callbacks, $this->rootNode($wsdl, $xml->documentElement));
            }

            $this->globalWsdls[self::XSD_NS]->addType(new SimpleType($this->globalWsdls[self::XSD_NS], "anySimpleType"));

            $this->globalWsdls[self::XML_NS]->addWsdl($this->globalWsdls[self::XSD_NS], self::XSD_NS);
            $this->globalWsdls[self::XSD_NS]->addWsdl($this->globalWsdls[self::XML_NS], self::XML_NS);

            foreach ($callbacks as $callback) {
                $callback();
            }
        }

        foreach ($this->globalWsdls as $globalWsdl) {
            $rootWsdl->addWsdl($globalWsdl, $globalWsdl->getTargetNamespace());
        }
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