<?php
namespace Goetas\XML\WSDLReader\Wsdl;

use Goetas\XML\XSDReader\Schema\Schema;
/**
 * XSD Type: tDefinitions
 */
class Definitions extends ExtensibleDocumented
{

    private $typeCache = array();
    /**
     * @var string
     */
    protected $targetNamespace;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $import = array();

    /**
     * @var array
     */
    protected $schema;

    /**
     * @var array
     */
    protected $message = array();

    /**
     * @var array
     */
    protected $portType = array();

    /**
     * @var array
     */
    protected $binding = array();

    /**
     * @var array
     */
    protected $service = array();

    public function __construct($defintion = null)
    {
        $this->schema = new Schema();
    }

    /**
     * @return string
     */
    public function getTargetNamespace()
    {
        return $this->targetNamespace;
    }
    /**
     * @param $targetNamespace string
     * @return \Goetas\XML\WSDLReader\Wsdl\TDefinitions
     */
    public function setTargetNamespace($targetNamespace)
    {
        $this->targetNamespace = $targetNamespace;
        return $this;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param $name string
     * @return \Goetas\XML\WSDLReader\Wsdl\TDefinitions
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }



    /**
     * @param $import \Goetas\XML\WSDLReader\Wsdl\Definitions
     */
    public function addImport(Definitions $import)
    {
        $this->import[] = $import;
        return $this;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Definitions[]
     */
    public function getImports()
    {
        return $this->import;
    }
    /**
     * @param $import \Goetas\XML\WSDLReader\Wsdl\Import[]
     * @return \Goetas\XML\WSDLReader\Wsdl\Definitions
     */
    public function setImport(array $import)
    {
        foreach ($import as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\Definitions) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\Import');
            }
        }
        $this->import = $import;
        return $this;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Types[]
     */
    public function getSchema()
    {
        return $this->schema;
    }
    /**
     * @param $types \Goetas\XML\WSDLReader\Wsdl\Types[]
     * @return \Goetas\XML\WSDLReader\Wsdl\TDefinitions
     */
    public function setTypes(array $types)
    {
        foreach ($types as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\Types) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\Types');
            }
        }
        $this->types = $types;
        return $this;
    }



    /**
     * @param $message \Goetas\XML\WSDLReader\Wsdl\Message
     */
    public function addMessage(\Goetas\XML\WSDLReader\Wsdl\Message $message)
    {
        $this->message[$message->getName()] = $message;
        return $this;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Message
     */
    public function getMessage($name)
    {
        return $this->message[$name];
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Message[]
     */
    public function getMessages()
    {
        return $this->message;
    }
    /**
     * @param $message \Goetas\XML\WSDLReader\Wsdl\Message[]
     * @return \Goetas\XML\WSDLReader\Wsdl\TDefinitions
     */
    public function setMessage(array $message)
    {
        foreach ($message as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\Message) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\Message');
            }
        }
        $this->message = $message;
        return $this;
    }



    /**
     * @param $portType \Goetas\XML\WSDLReader\Wsdl\PortType
     */
    public function addPortType(\Goetas\XML\WSDLReader\Wsdl\PortType $portType)
    {
        $this->portType[$portType->getName()] = $portType;
        return $this;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType
     */
    public function getPortType($name)
    {
        return $this->portType[$name];
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType[]
     */
    public function getPortTypes()
    {
        return $this->portType;
    }
    /**
     * @param $portType \Goetas\XML\WSDLReader\Wsdl\PortType[]
     * @return \Goetas\XML\WSDLReader\Wsdl\TDefinitions
     */
    public function setPortType(array $portType)
    {
        foreach ($portType as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\PortType) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\PortType');
            }
        }
        $this->portType = $portType;
        return $this;
    }



    /**
     * @param $binding \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    public function addBinding(\Goetas\XML\WSDLReader\Wsdl\Binding $binding)
    {
        $this->binding[$binding->getName()] = $binding;
        return $this;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding($name)
    {
        return $this->binding[$name];
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding[]
     */
    public function getBindings()
    {
        return $this->binding;
    }
    /**
     * @param $binding \Goetas\XML\WSDLReader\Wsdl\Binding[]
     * @return \Goetas\XML\WSDLReader\Wsdl\TDefinitions
     */
    public function setBinding(array $binding)
    {
        foreach ($binding as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\Binding) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\Binding');
            }
        }
        $this->binding = $binding;
        return $this;
    }



    /**
     * @param $service \Goetas\XML\WSDLReader\Wsdl\Service
     */
    public function addService(\Goetas\XML\WSDLReader\Wsdl\Service $service)
    {
        $this->service[$service->getName()] = $service;
        return $this;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Service[]
     */
    public function getService()
    {
        return $this->service;
    }
    /**
     * @param $service \Goetas\XML\WSDLReader\Wsdl\Service[]
     * @return \Goetas\XML\WSDLReader\Wsdl\TDefinitions
     */
    public function setService(array $service)
    {
        foreach ($service as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\Service) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\Service');
            }
        }
        $this->service = $service;
        return $this;
    }

    public function findBinding($name, $namespace = null)
    {
        return $this->findSomething('getBinding', $name, $namespace);
    }

    public function findPortType($name, $namespace = null)
    {
        return $this->findSomething('getPortType', $name, $namespace);
    }

    public function findMessage($name, $namespace = null)
    {
        return $this->findSomething('getMessage', $name, $namespace);
    }

    /**
     *
     * @param string $getter
     * @param string $name
     * @param string $namespace
     * @throws TypeNotFoundException
     * @return \Goetas\XML\XSDReader\Schema\SchemaItem
     */
    protected function findSomething($getter, $name, $namespace = null)
    {
        $cid = "$getter, $name, $namespace";

        if (isset($this->typeCache[$cid])) {
            return $this->typeCache[$cid];
        }

        if (null === $namespace || $this->getTargetNamespace() === $namespace) {
            if ($item = $this->$getter($name)) {
                return $this->typeCache[$cid] = $item;
            }
        }

        foreach ($this->getImports() as $childSchema) {
            if ($childSchema->getTargetNamespace() === $namespace) {
                try {
                    return $this->typeCache[$cid] = $childSchema->findSomething($getter, $name, $namespace);
                } catch (TypeNotFoundException $e) {
                }
            }
        }
        throw new TypeNotFoundException(sprintf("Can't find the %s named {%s}#%s.", substr($getter, 3), $namespace, $name));
    }


}
