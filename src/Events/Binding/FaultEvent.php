<?php
namespace GoetasWebservices\XML\WSDLReader\Events\Binding;

use Symfony\Component\EventDispatcher\Event;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation;
use GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault;
use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;

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