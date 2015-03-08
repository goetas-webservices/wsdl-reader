<?php
namespace Goetas\XML\WSDLReader\Wsdl\Binding;

use Goetas\XML\WSDLReader\Wsdl\ExtensibleDocumented;
/**
 * XSD Type: tBindingOperationMessage
 */
class OperationMessage extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;
    /**
     *
     * @var \Goetas\XML\WSDLReader\Wsdl\Binding\Operation
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
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
}
