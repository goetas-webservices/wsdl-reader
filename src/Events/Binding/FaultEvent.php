<?php
namespace GoetasWebservices\XML\WSDLReader\Events\Binding;

use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault;
use Symfony\Component\EventDispatcher\Event;

class FaultEvent extends WsdlEvent
{

    protected $Fault;

    public function __construct(OperationFault $Fault, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Fault = $Fault;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault
     */
    public function getFault()
    {
        return $this->Fault;
    }
}