<?php
namespace Goetas\XML\WSDLReader\Wsdl;

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
     * @var string
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
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @param $type string
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    public function setType(PortType $type)
    {
        $this->type = $type;
        return $this;
    }



    /**
     * @param $operation \Goetas\XML\WSDLReader\Wsdl\BindingOperation
     */
    public function addOperation(\Goetas\XML\WSDLReader\Wsdl\BindingOperation $operation)
    {
        $this->operation[$operation->getName()] = $operation;
        return $this;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingOperation[]
     */
    public function getOperation()
    {
        return $this->operation;
    }
    /**
     * @param $operation \Goetas\XML\WSDLReader\Wsdl\BindingOperation[]
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    public function setOperation(array $operation)
    {
        foreach ($operation as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\BindingOperation) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\BindingOperation');
            }
        }
        $this->operation = $operation;
        return $this;
    }

}
