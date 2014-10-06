<?php
namespace Goetas\XML\WSDLReader\Events\Binding;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\Binding\Operation;
use Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage;
use Goetas\XML\WSDLReader\Events\NodeEvent;

class MessageEvent extends NodeEvent
{

    protected $Fault;

    public function __construct(OperationMessage $Fault, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Fault = $Fault;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    public function getOperationMessage()
    {
        return $this->Fault;
    }
}

