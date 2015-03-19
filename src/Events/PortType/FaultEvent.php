<?php
namespace GoetasWebservices\XML\WSDLReader\Events\PortType;

use Symfony\Component\EventDispatcher\Event;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Operation;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Fault;
use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;

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