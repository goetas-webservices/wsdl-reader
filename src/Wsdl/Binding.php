<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl;

use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation;

/**
 * XSD Type: tBinding
 */
class Binding extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var PortType
     */
    protected $type;

    /**
     * @var array
     */
    protected $operation = array();


    public function __construct(Definitions $def, $name)
    {
        parent::__construct($def);
        $this->name = $name;
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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return PortType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type string
     * @return PortType
     */
    public function setType(PortType $type)
    {
        $this->type = $type;
        return $this;
    }


    /**
     * @param Operation $operation
     * @return Binding
     */
    public function addOperation(Operation $operation)
    {
        $this->operation[$operation->getName()] = $operation;
        return $this;
    }

    /**
     * @return Operation
     */
    public function getOperation($name)
    {
        return $this->operation[$name];
    }

    /**
     * @return Operation[]
     */
    public function getOperations()
    {
        return $this->operation;
    }
}
