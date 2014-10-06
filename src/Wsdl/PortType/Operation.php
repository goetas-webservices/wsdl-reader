<?php
namespace Goetas\XML\WSDLReader\Wsdl\PortType;

use Goetas\XML\WSDLReader\Wsdl\ExtensibleDocumented;
use Goetas\XML\WSDLReader\Wsdl\PortType;
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
    protected $fault = array();

    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\PortType
     */
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
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Operation
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
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function setParameterOrder($parameterOrder)
    {
        $this->parameterOrder = $parameterOrder;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @param $input \Goetas\XML\WSDLReader\Wsdl\PortType\Param
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function setInput(\Goetas\XML\WSDLReader\Wsdl\PortType\Param $input)
    {
        $this->input = $input;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * @param $output \Goetas\XML\WSDLReader\Wsdl\PortType\Param
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function setOutput(\Goetas\XML\WSDLReader\Wsdl\PortType\Param $output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Fault
     */
    public function getFault($name)
    {
        return $this->fault[$name];
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Fault[]
     */
    public function getFaults()
    {
        return $this->fault;
    }
    /**
     * @param $fault \Goetas\XML\WSDLReader\Wsdl\PortType\Fault
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function addFault(\Goetas\XML\WSDLReader\Wsdl\PortType\Fault $fault)
    {
        $this->fault[$fault->getName()] = $fault;
        return $this;
    }

}
