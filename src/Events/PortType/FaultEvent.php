<?php
namespace Goetas\XML\WSDLReader\Events\PortType;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\PortType\Operation;
use Goetas\XML\WSDLReader\Wsdl\PortType\Fault;
use Goetas\XML\WSDLReader\Events\WsdlEvent;

class FaultEvent extends WsdlEvent
{

    protected $Fault;

    public function __construct(Fault $Fault, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Fault = $Fault;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Fault
     */
    public function getFault()
    {
        return $this->Fault;
    }
}