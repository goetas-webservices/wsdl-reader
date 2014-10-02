<?php
namespace Goetas\XML\WSDLReader\Wsdl;

/**
 * XSD Type: tOperation
 */
class Operation extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $parameterOrder;

    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Param
     */
    protected $input;

    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Param
     */
    protected $output;

    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Fault
     */
    protected $fault;

    protected $port;

    public function __construct(PortType $port, $name)
    {
        parent::__construct($port->getDefinition());

        $this->name = $name;
        $this->port = $port;
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
     * @return \Goetas\XML\WSDLReader\Wsdl\Operation
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return string
     */
    public function getParameterOrder()
    {
        return $this->parameterOrder;
    }
    /**
     * @param $parameterOrder string
     * @return \Goetas\XML\WSDLReader\Wsdl\Operation
     */
    public function setParameterOrder($parameterOrder)
    {
        $this->parameterOrder = $parameterOrder;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Param
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @param $input \Goetas\XML\WSDLReader\Wsdl\Param
     * @return \Goetas\XML\WSDLReader\Wsdl\Operation
     */
    public function setInput(\Goetas\XML\WSDLReader\Wsdl\Param $input)
    {
        $this->input = $input;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Param
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * @param $output \Goetas\XML\WSDLReader\Wsdl\Param
     * @return \Goetas\XML\WSDLReader\Wsdl\Operation
     */
    public function setOutput(\Goetas\XML\WSDLReader\Wsdl\Param $output)
    {
        $this->output = $output;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Fault
     */
    public function getFault()
    {
        return $this->fault;
    }
    /**
     * @param $fault \Goetas\XML\WSDLReader\Wsdl\Fault
     * @return \Goetas\XML\WSDLReader\Wsdl\Operation
     */
    public function setFault(\Goetas\XML\WSDLReader\Wsdl\Fault $fault)
    {
        $this->fault = $fault;
        return $this;
    }

}
