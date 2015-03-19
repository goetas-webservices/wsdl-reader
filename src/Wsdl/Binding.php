<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl;

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
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\PortType
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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @param $type string
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType
     */
    public function setType(PortType $type)
    {
        $this->type = $type;
        return $this;
    }



    /**
     * @param $operation \GoetasWebservices\XML\WSDLReader\Wsdl\BindingOperation
     */
    public function addOperation(\GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation $operation)
    {
        $this->operation[$operation->getName()] = $operation;
        return $this;
    }
    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function getOperation($name)
    {
        return $this->operation[$name];
    }
    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation[]
     */
    public function getOperations()
    {
        return $this->operation;
    }
}
