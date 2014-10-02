<?php
namespace Goetas\XML\WSDLReader\Wsdl;

/**
 * XSD Type: tBindingOperationMessage
 */
class BindingOperationMessage extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;

    protected $operation;


    public function __construct(BindingOperation $operation, $name)
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
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

}
