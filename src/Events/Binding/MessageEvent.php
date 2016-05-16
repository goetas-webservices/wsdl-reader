<?php
namespace GoetasWebservices\XML\WSDLReader\Events\Binding;

use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage;
use Symfony\Component\EventDispatcher\Event;

class MessageEvent extends WsdlEvent
{

    protected $type;
    protected $message;

    /**
     * MessageEvent constructor.
     * @param OperationMessage $message
     * @param \DOMElement $node
     * @param $type
     */
    public function __construct(OperationMessage $message, \DOMElement $node, $type)
    {
        parent::__construct($node);
        $this->message = $message;
        $this->type = $type;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    public function getOperationMessage()
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}


