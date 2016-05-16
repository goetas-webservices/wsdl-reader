<?php
namespace GoetasWebservices\XML\WSDLReader\Events\PortType;

use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Fault;
use Symfony\Component\EventDispatcher\Event;

class FaultEvent extends WsdlEvent
{

    protected $Fault;

    public function __construct(Fault $Fault, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Fault = $Fault;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Fault
     */
    public function getFault()
    {
        return $this->Fault;
    }
}