<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl\Binding;

use GoetasWebservices\XML\WSDLReader\Wsdl\Binding;
use GoetasWebservices\XML\WSDLReader\Wsdl\ExtensibleDocumented;

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
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    protected $input;

    /**
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage
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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @param $input \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function setInput(\GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage $input)
    {
        $this->input = $input;
        return $this;
    }


    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    public function getOutput()
    {
        return $this->output;
    }

    /**
     * @param $output \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function setOutput(\GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage $output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @param $fault \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault
     */
    public function addFault(\GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault $fault)
    {
        $this->fault[$fault->getName()] = $fault;
        return $this;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault[]
     */
    public function getFaults()
    {
        return $this->fault;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding()
    {
        return $this->binding;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function getPortTypeOperation()
    {
        return $this->binding->getType()->getOperation($this->name);
    }

}
