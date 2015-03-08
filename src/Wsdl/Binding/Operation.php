<?php
namespace Goetas\XML\WSDLReader\Wsdl\Binding;

use Goetas\XML\WSDLReader\Wsdl\ExtensibleDocumented;
use Goetas\XML\WSDLReader\Wsdl\Binding;
/**
 * XSD Type: tBindingOperation
 */
class Operation extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    protected $input;

    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage
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
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @param $input \Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function setInput(\Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage $input)
    {
        $this->input = $input;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * @param $output \Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function setOutput(\Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage $output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @param $fault \Goetas\XML\WSDLReader\Wsdl\Binding\OperationFault
     */
    public function addFault(\Goetas\XML\WSDLReader\Wsdl\Binding\OperationFault $fault)
    {
        $this->fault[$fault->getName()] = $fault;
        return $this;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\OperationFault[]
     */
    public function getFaults()
    {
        return $this->fault;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding()
    {
        $this->binding;
    }

}
