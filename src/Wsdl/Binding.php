<?php
namespace PhpWebservices\XML\WSDLReader\Wsdl;

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
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\PortType
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
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Binding
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @param $type string
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType
     */
    public function setType(PortType $type)
    {
        $this->type = $type;
        return $this;
    }



    /**
     * @param $operation \PhpWebservices\XML\WSDLReader\Wsdl\BindingOperation
     */
    public function addOperation(\PhpWebservices\XML\WSDLReader\Wsdl\Binding\Operation $operation)
    {
        $this->operation[$operation->getName()] = $operation;
        return $this;
    }
    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function getOperation($name)
    {
        return $this->operation[$name];
    }
    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Binding\Operation[]
     */
    public function getOperations()
    {
        return $this->operation;
    }
}
