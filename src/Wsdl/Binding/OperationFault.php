<?php
namespace PhpWebservices\XML\WSDLReader\Wsdl\Binding;

use PhpWebservices\XML\WSDLReader\Wsdl\ExtensibleDocumented;
/**
 * XSD Type: tBindingOperationFault
 */
class OperationFault extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;
    /**
     *
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\Binding\Operation
     */
    protected $operation;

    public function __construct(Operation $operation, $name)
    {
        parent::__construct($operation->getDefinition());

        $this->name = $name;
        $this->operation = $operation;
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
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }

}
