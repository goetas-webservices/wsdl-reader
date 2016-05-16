<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl\PortType;

use GoetasWebservices\XML\WSDLReader\Wsdl\ExtensibleAttributesDocumented;
use GoetasWebservices\XML\WSDLReader\Wsdl\Message;

/**
 * XSD Type: tParam
 */
class Param extends ExtensibleAttributesDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $message;

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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message string
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
        return $this;
    }

}
