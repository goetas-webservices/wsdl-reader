<?php
namespace PhpWebservices\XML\WSDLReader\Events\PortType;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\PortType\Operation;
use PhpWebservices\XML\WSDLReader\Wsdl\PortType\Fault;
use PhpWebservices\XML\WSDLReader\Events\WsdlEvent;

class FaultEvent extends WsdlEvent
{

    protected $Fault;

    public function __construct(Fault $Fault, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Fault = $Fault;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Fault
     */
    public function getFault()
    {
        return $this->Fault;
    }
}