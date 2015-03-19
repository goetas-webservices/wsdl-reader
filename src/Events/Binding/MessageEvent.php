<?php
namespace GoetasWebservices\XML\WSDLReader\Events\Binding;

use Symfony\Component\EventDispatcher\Event;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage;
use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;

class MessageEvent extends WsdlEvent
{

    protected $Fault;

    public function __construct(OperationMessage $Fault, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Fault = $Fault;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    public function getOperationMessage()
    {
        return $this->Fault;
    }
}

