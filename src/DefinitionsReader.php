<?php
namespace GoetasWebservices\XML\WSDLReader;

use DOMDocument;
use DOMElement;
use GoetasWebservices\XML\WSDLReader\Events\Binding\FaultEvent as BindingOperationFaultEvent;
use GoetasWebservices\XML\WSDLReader\Events\Binding\MessageEvent as BindingOperationMessageEvent;
use GoetasWebservices\XML\WSDLReader\Events\Binding\OperationEvent as BindingOperationEvent;
use GoetasWebservices\XML\WSDLReader\Events\BindingEvent;
use GoetasWebservices\XML\WSDLReader\Events\DefinitionsEvent;
use GoetasWebservices\XML\WSDLReader\Events\Message\PartEvent as MessagePartEvent;
use GoetasWebservices\XML\WSDLReader\Events\MessageEvent;
use GoetasWebservices\XML\WSDLReader\Events\PortType\FaultEvent;
use GoetasWebservices\XML\WSDLReader\Events\PortType\OperationEvent;
use GoetasWebservices\XML\WSDLReader\Events\PortType\ParamEvent;
use GoetasWebservices\XML\WSDLReader\Events\PortTypeEvent;
use GoetasWebservices\XML\WSDLReader\Events\Service\PortEvent;
use GoetasWebservices\XML\WSDLReader\Events\ServiceEvent;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation as BindingOperation;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault as BindingOperationFault;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage as BindingOperationMessage;
use GoetasWebservices\XML\WSDLReader\Wsdl\Definitions;
use GoetasWebservices\XML\WSDLReader\Wsdl\Message;
use GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Fault;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Operation;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param;
use GoetasWebservices\XML\WSDLReader\Wsdl\Service;
use GoetasWebservices\XML\WSDLReader\Wsdl\Service\Port;
use GoetasWebservices\XML\XSDReader\Exception\IOException;
use GoetasWebservices\XML\XSDReader\Schema\Schema;
use GoetasWebservices\XML\XSDReader\SchemaReader;
use GoetasWebservices\XML\XSDReader\Utils\UrlUtils;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class DefinitionsReader
{

    const WSDL_NS = "http://schemas.xmlsoap.org/wsdl/";

    const XSD_NS = "http://www.w3.org/2001/XMLSchema";

    private $loadedFiles = array();

    /**
     *
     * @var \GoetasWebservices\XML\XSDReader\SchemaReader
     */
    private $reader;

    /**
     *
     * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
     */
    private $dispatcher;

    public function __construct(SchemaReader $reader = null, EventDispatcherInterface $dispatcher = null)
    {
        $this->reader = $reader ?: new SchemaReader();
        $this->dispatcher = $dispatcher ?: new EventDispatcher();
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

    private function loop(DOMElement $node)
    {
        $childs = array();
        foreach ($node->childNodes as $childNode) {
            if (!($childNode instanceof DOMElement) || $childNode->namespaceURI !== self::WSDL_NS) {
                continue;
            }
            $childs[] = $childNode;
        }
        return $childs;
    }

    private function dispatch($eventName, Event $event)
    {
        ;
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
        if ($node->hasAttribute("name")) {
            $definitions->setName($node->getAttribute("name"));
        }

        $functions = array();
        foreach ($this->loop($node) as $childNode) {
            switch ($childNode->localName) {
                case 'import':
                    $functions[0][] = $this->loadImport($definitions, $childNode);
                    break;
                case 'types':
                    $this->loadTypes($definitions, $childNode);
                    break;
                case 'message':
                    $functions[2][] = $this->loadMessage($definitions, $childNode);
                    break;
                case 'portType':
                    $functions[3][] = $this->loadPortType($definitions, $childNode);
                    break;
                case 'binding':
                    $functions[4][] = $this->loadBinding($definitions, $childNode);
                    break;
                case 'service':
                    $functions[1][] = $this->loadService($definitions, $childNode);
                    break;
            }
        }
        ksort($functions);
        return array(
            function () use ($functions, $definitions, $node) {
                $this->dispatcher->dispatch('definitions_start', new DefinitionsEvent($definitions, $node));
                foreach ($functions as $subFunctions) {
                    foreach ($subFunctions as $function) {
                        call_user_func($function);
                    }
                }
                $this->dispatcher->dispatch('definitions_end', new DefinitionsEvent($definitions, $node));
            }
        );
    }

    private function loadTypes(Definitions $definitions, \DOMElement $node)
    {
        $schema = $this->reader->readNodes(iterator_to_array($node->childNodes), $node->ownerDocument->documentURI);
        $definitions->getSchema()->addSchema($schema);
    }

    private function loadBinding(Definitions $definitions, DOMElement $node)
    {
        $binding = new Binding($definitions, $node->getAttribute("name"));
        $binding->setDocumentation($this->getDocumentation($node));
        $definitions->addBinding($binding);

        $functions = array();
        foreach ($this->loop($node) as $childNode) {
            switch ($childNode->localName) {
                case 'operation':
                    $functions[] = $this->loadBindingOperation($binding, $childNode);
                    break;
            }
        }
        return function () use ($functions, $binding, $definitions, $node) {
            list ($name, $ns) = self::splitParts($node, $node->getAttribute("type"));
            $binding->setType($definitions->findPortType($name, $ns));

            $this->dispatcher->dispatch('binding', new BindingEvent($binding, $node));
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
        foreach ($this->loop($node) as $childNode) {
            switch ($childNode->localName) {
                case 'input':
                    $functions[] = $this->loadBindingOperationMessage($bindingOperation, $childNode, true);
                    break;
                case 'output':
                    $functions[] = $this->loadBindingOperationMessage($bindingOperation, $childNode, false);
                    break;
                case 'fault':
                    $functions[] = $this->loadBindingOperationFault($bindingOperation, $childNode);
                    break;
            }
        }
        return function () use ($functions, $bindingOperation, $node) {
            $this->dispatcher->dispatch('binding.operation', new BindingOperationEvent($bindingOperation, $node));
            foreach ($functions as $function) {
                call_user_func($function);
            }
        };
    }

    private function loadBindingOperationMessage(BindingOperation $bindingOperation, DOMElement $node, $isInput)
    {
        $message = new BindingOperationMessage($bindingOperation, $node->getAttribute("name"));
        $message->setDocumentation($this->getDocumentation($node));
        if ($isInput) {
            $bindingOperation->setInput($message);
        } else {
            $bindingOperation->setOutput($message);
        }

        return function () use ($message, $node, $isInput) {
            $this->dispatcher->dispatch('binding.operation.message', new BindingOperationMessageEvent($message, $node, $isInput ? 'input' : 'output'));
        };
    }

    private function loadBindingOperationFault(BindingOperation $bindingOperation, DOMElement $node)
    {
        $fault = new BindingOperationFault($bindingOperation, $node->getAttribute("name"));
        $fault->setDocumentation($this->getDocumentation($node));
        $bindingOperation->addFault($fault);

        return function () use ($fault, $node) {
            $this->dispatcher->dispatch('binding.operation.fault', new BindingOperationFaultEvent($fault, $node));
        };
    }

    private function loadService(Definitions $definitions, DOMElement $node)
    {
        $service = new Service($definitions, $node->getAttribute("name"));
        $service->setDocumentation($this->getDocumentation($node));
        $definitions->addService($service);

        $functions = array();
        foreach ($this->loop($node) as $childNode) {
            switch ($childNode->localName) {
                case 'port':
                    $functions[] = $this->loadPort($service, $childNode);
                    break;
            }
        }
        return function () use ($functions, $service, $node) {
            $this->dispatcher->dispatch('service', new ServiceEvent($service, $node));
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

        $functions = array();
        foreach ($this->loop($node) as $childNode) {
            switch ($childNode->localName) {
                case 'part':
                    $functions[] = $this->loadMessagePart($message, $childNode);
                    break;
            }
        }

        return function () use ($functions, $message, $node) {
            $this->dispatcher->dispatch('message', new MessageEvent($message, $node));
            foreach ($functions as $function) {
                call_user_func($function);
            }
        };
    }

    private function loadPort(Service $service, DOMElement $node)
    {
        $port = new Port($service, $node->getAttribute("name"));
        $port->setDocumentation($this->getDocumentation($node));
        $service->addPort($port);
        return function () use ($port, $service, $node) {
            list ($name, $ns) = self::splitParts($node, $node->getAttribute("binding"));
            $port->setBinding($service->getDefinition()
                ->findBinding($name, $ns));
            $this->dispatcher->dispatch('service.port', new PortEvent($port, $node));
        };
    }

    private function loadPortType(Definitions $definitions, DOMElement $node)
    {
        $port = new PortType($definitions, $node->getAttribute("name"));
        $port->setDocumentation($this->getDocumentation($node));
        $definitions->addPortType($port);

        $functions = array();
        foreach ($this->loop($node) as $childNode) {
            switch ($childNode->localName) {
                case 'operation':
                    $functions[] = $this->loadPortTypeOperation($port, $childNode);
                    break;
            }
        }
        return function () use ($functions, $port, $node) {
            $this->dispatcher->dispatch('portType', new PortTypeEvent($port, $node));
            foreach ($functions as $function) {
                call_user_func($function);
            }
        };
    }

    private function loadPortTypeOperation(PortType $port, DOMElement $node)
    {
        $operation = new Operation($port, $node->getAttribute("name"));
        $operation->setDocumentation($this->getDocumentation($node));
        $operation->setParameterOrder($node->getAttribute("parameterOrder") ?: null);
        $port->addOperation($operation);

        $functions = array();
        foreach ($this->loop($node) as $childNode) {
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
        return function () use ($functions, $operation, $node) {
            $this->dispatcher->dispatch('portType.operation', new OperationEvent($operation, $node));
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

        return function () use ($param, $operation, $node) {
            list ($name, $ns) = self::splitParts($node, $node->getAttribute("message"));
            $param->setMessage($operation->getDefinition()
                ->findMessage($name, $ns));
            $this->dispatcher->dispatch('portType.operation.param', new ParamEvent($param, $node));
        };
    }

    private function loadFault(Operation $operation, DOMElement $node)
    {
        $fault = new Fault($operation, $node->getAttribute("name"));
        $fault->setDocumentation($this->getDocumentation($node));
        $operation->addFault($fault);

        return function () use ($fault, $operation, $node) {
            list ($name, $ns) = self::splitParts($node, $node->getAttribute("message"));
            $fault->setMessage($operation->getDefinition()->findMessage($name, $ns));

            $this->dispatcher->dispatch('portType.operation.fault', new FaultEvent($fault, $node));
        };
    }

    private function loadMessagePart(Message $message, DOMElement $node)
    {
        $part = new Part($message, $node->getAttribute("name"));
        $part->setDocumentation($this->getDocumentation($node));
        $message->addPart($part);

        return function () use ($part, $node) {
            if ($node->hasAttribute("element")) {
                list ($name, $ns) = self::splitParts($node, $node->getAttribute("element"));
                $part->setElement($part->getDefinition()
                    ->getSchema()
                    ->findElement($name, $ns));
            } elseif ($node->hasAttribute("type")) {
                list ($name, $ns) = self::splitParts($node, $node->getAttribute("type"));
                $part->setType($part->getDefinition()
                    ->getSchema()
                    ->findType($name, $ns));
            }
            $this->dispatcher->dispatch('message.part', new MessagePartEvent($part, $node));
        };
    }

    public static function splitParts(DOMElement $node, $typeName)
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
            $definitions->addImport($this->loadedFiles[$file]);
            return function () {
            };
        }

        if (!$node->getAttribute("namespace")) {
            $this->loadedFiles[$file] = $newDefinitions = $definitions;
        } else {
            $this->loadedFiles[$file] = $newDefinitions = new Definitions();
            $schema = new Schema();
            $schema->addSchema($this->reader->getGlobalSchema());
            $newDefinitions->setSchema($schema);
        }

        $xml = $this->getDOM($file);

        $callbacks = $this->rootNode($newDefinitions, $xml->documentElement, $definitions);

        if ($node->getAttribute("namespace")) {
            $definitions->addImport($newDefinitions);
        }

        return function () use ($callbacks) {
            foreach ($callbacks as $callback) {
                call_user_func($callback);
            }
        };
    }

    /**
     *
     * @return \oetas\XML\WSDLReader\Wsdl\Definitions
     */
    public function readNode(\DOMElement $node, $file = 'wsdl.xsd')
    {
        $this->loadedFiles[$file] = $rootDefinitions = new Definitions();
        $schema = new Schema();
        $schema->addSchema($this->reader->getGlobalSchema());

        $rootDefinitions->setSchema($schema);

        $callbacks = $this->rootNode($rootDefinitions, $node);

        foreach ($callbacks as $callback) {
            call_user_func($callback);
        }

        return $rootDefinitions;
    }

    /**
     *
     * @return \oetas\XML\WSDLReader\Wsdl\Definitions
     */
    public function readString($content, $file = 'wsdl.xsd')
    {
        $xml = new DOMDocument('1.0', 'UTF-8');
        if (!$xml->loadXML($content)) {
            throw new IOException("Can't load the wsdl");
        }
        $xml->documentURI = $file;

        return $this->readNode($xml->documentElement, $file);
    }

    /**
     *
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Definitions
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
        if (!$xml->load($file, LIBXML_NONET)) {
            print_r(libxml_get_errors());
            die();
            throw new IOException("Can't load the file $file");

        }
        return $xml;
    }
}
