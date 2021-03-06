<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl;

use GoetasWebservices\XML\WSDLReader\Exception\ServiceNotFoundException;
use GoetasWebservices\XML\XSDReader\Schema\Schema;

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
     * @var \GoetasWebservices\XML\XSDReader\Schema\Schema
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

    public function __construct()
    {
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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\TDefinitions
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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\TDefinitions
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $import \GoetasWebservices\XML\WSDLReader\Wsdl\Definitions
     */
    public function addImport(Definitions $import)
    {
        $this->import[] = $import;
        $this->getSchema()->addSchema($import->getSchema());
        return $this;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Definitions[]
     */
    public function getImports()
    {
        return $this->import;
    }

    /**
     * @return \GoetasWebservices\XML\XSDReader\Schema\Schema
     */
    public function getSchema()
    {
        return $this->schema;
    }


    /**
     * @param Schema $schema
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Definitions
     */
    public function setSchema(Schema $schema)
    {
        $this->schema = $schema;
        return $this;
    }


    /**
     * @param $message \GoetasWebservices\XML\WSDLReader\Wsdl\Message
     */
    public function addMessage(\GoetasWebservices\XML\WSDLReader\Wsdl\Message $message)
    {
        $this->message[$message->getName()] = $message;
        return $this;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message
     */
    public function getMessage($name)
    {
        if (isset($this->message[$name])) {
            return $this->message[$name];
        }
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message[]
     */
    public function getMessages()
    {
        return $this->message;
    }

    /**
     * @param $portType \GoetasWebservices\XML\WSDLReader\Wsdl\PortType
     */
    public function addPortType(\GoetasWebservices\XML\WSDLReader\Wsdl\PortType $portType)
    {
        $this->portType[$portType->getName()] = $portType;
        return $this;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType
     */
    public function getPortType($name)
    {
        return $this->portType[$name];
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType[]
     */
    public function getPortTypes()
    {
        return $this->portType;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType[]
     */
    public function getAllPortTypes()
    {
        $types = $this->getPortTypes();
        foreach ($this->getImports() as $child) {
            $types = array_merge($types, $child->getAllPortTypes());
        }
        return $types;
    }

    /**
     * @param $binding \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     */
    public function addBinding(\GoetasWebservices\XML\WSDLReader\Wsdl\Binding $binding)
    {
        $this->binding[$binding->getName()] = $binding;
        return $this;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding($name)
    {
        if (isset($this->binding[$name])) {
            return $this->binding[$name];
        }
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding[]
     */
    public function getBindings()
    {
        return $this->binding;
    }

    /**
     * @param $service \GoetasWebservices\XML\WSDLReader\Wsdl\Service
     */
    public function addService(\GoetasWebservices\XML\WSDLReader\Wsdl\Service $service)
    {
        $this->service[$service->getName()] = $service;
        return $this;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Service
     */
    public function getService($name)
    {
        if (isset($this->service[$name])) {
            return $this->service[$name];
        }
        throw new ServiceNotFoundException("The service named $name can not be found inside $this->name");
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Service[]
     */
    public function getServices()
    {
        return $this->service;
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     */
    public function findBinding($name, $namespace = null)
    {
        return $this->findSomething('getBinding', $name, $namespace);
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType
     */
    public function findPortType($name, $namespace = null)
    {
        return $this->findSomething('getPortType', $name, $namespace);
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Service
     */
    public function findService($name, $namespace = null)
    {
        return $this->findSomething('getService', $name, $namespace);
    }

    /**
     * @param string $name
     * @param string $namespace
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message
     */
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
     * @return mixed
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
