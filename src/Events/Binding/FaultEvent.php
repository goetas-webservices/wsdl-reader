<?php
namespace PhpWebservices\XML\WSDLReader\Events\Binding;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\Binding\Operation;
use PhpWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault;
use PhpWebservices\XML\WSDLReader\Events\WsdlEvent;

class FaultEvent extends WsdlEvent
{

    protected $Fault;

    public function __construct(OperationFault $Fault, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Fault = $Fault;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault
     */
    public function getFault()
    {
        return $this->Fault;
    }
}