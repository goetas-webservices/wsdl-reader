<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl\PortType;

use GoetasWebservices\XML\WSDLReader\Wsdl\ExtensibleAttributesDocumented;
use GoetasWebservices\XML\WSDLReader\Wsdl\Message;

/**
 * XSD Type: tFault
 */
class Fault extends ExtensibleAttributesDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Message
     */
    protected $message;

    /**
     *
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Operation
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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Fault
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param $message Message
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Fault
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
        return $this;
    }

}
