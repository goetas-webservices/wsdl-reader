<?php
namespace Goetas\XML\WSDLReader\Wsdl;

/**
 * XSD Type: tPortType
 */
class PortType extends ExtensibleAttributesDocumented
{

    /**
     * @var string
     */
    protected $name;

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
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }



    /**
     * @param $operation \Goetas\XML\WSDLReader\Wsdl\Operation
     */
    public function addOperation(\Goetas\XML\WSDLReader\Wsdl\Operation $operation)
    {
        $this->operation[$operation->getName()] = $operation;
        return $this;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Operation[]
     */
    public function getOperation()
    {
        return $this->operation;
    }
    /**
     * @param $operation \Goetas\XML\WSDLReader\Wsdl\Operation[]
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType
     */
    public function setOperation(array $operation)
    {
        foreach ($operation as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\Operation) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\Operation');
            }
        }
        $this->operation = $operation;
        return $this;
    }

}
