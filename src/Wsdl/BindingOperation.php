<?php
namespace Goetas\XML\WSDLReader\Wsdl;

/**
 * XSD Type: tBindingOperation
 */
class BindingOperation extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage
     */
    protected $input;

    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage
     */
    protected $output;

    /**
     * @var array
     */
    protected $fault = array();

    protected $binding;

    public function __construct(Binding $binding, $name)
    {
        parent::__construct($binding->getDefinition());
        $this->name = $name;
        $this->binding = $binding;
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
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingOperation
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @param $input \Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingOperation
     */
    public function setInput(\Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage $input)
    {
        $this->input = $input;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * @param $output \Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingOperation
     */
    public function setOutput(\Goetas\XML\WSDLReader\Wsdl\BindingOperationMessage $output)
    {
        $this->output = $output;
        return $this;
    }



    /**
     * @param $fault \Goetas\XML\WSDLReader\Wsdl\BindingOperationFault
     */
    public function addFault(\Goetas\XML\WSDLReader\Wsdl\BindingOperationFault $fault)
    {
        $this->fault[] = $fault;
        return $this;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingOperationFault[]
     */
    public function getFault()
    {
        return $this->fault;
    }
    /**
     * @param $fault \Goetas\XML\WSDLReader\Wsdl\BindingOperationFault[]
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingOperation
     */
    public function setFault(array $fault)
    {
        foreach ($fault as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\BindingOperationFault) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\BindingOperationFault');
            }
        }
        $this->fault = $fault;
        return $this;
    }

}
