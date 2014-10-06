<?php
namespace Goetas\XML\WSDLReader\Events\Binding;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\Binding\Operation;
use Goetas\XML\WSDLReader\Wsdl\Binding\OperationFault;
use Goetas\XML\WSDLReader\Events\NodeEvent;

class FaultEvent extends NodeEvent
{

    protected $Fault;

    public function __construct(OperationFault $Fault, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Fault = $Fault;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\OperationFault
     */
    public function getFault()
    {
        return $this->Fault;
    }
}