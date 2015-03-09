<?php
namespace PhpWebservices\XML\WSDLReader\Wsdl\PortType;

use PhpWebservices\XML\WSDLReader\Wsdl\ExtensibleDocumented;
use PhpWebservices\XML\WSDLReader\Wsdl\PortType;
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
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    protected $input;

    /**
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    protected $output;

    /**
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Fault[]
     */
    protected $fault = array();

    /**
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\PortType
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
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Operation
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
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function setParameterOrder($parameterOrder)
    {
        $this->parameterOrder = $parameterOrder;
        return $this;
    }


    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @param $input \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function setInput(\PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param $input)
    {
        $this->input = $input;
        return $this;
    }


    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * @param $output \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function setOutput(\PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param $output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Fault
     */
    public function getFault($name)
    {
        return $this->fault[$name];
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Fault[]
     */
    public function getFaults()
    {
        return $this->fault;
    }
    /**
     * @param $fault \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Fault
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function addFault(\PhpWebservices\XML\WSDLReader\Wsdl\PortType\Fault $fault)
    {
        $this->fault[$fault->getName()] = $fault;
        return $this;
    }

}
