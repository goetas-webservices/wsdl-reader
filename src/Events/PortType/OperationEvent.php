<?php
namespace GoetasWebservices\XML\WSDLReader\Events\PortType;

use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Operation;

class OperationEvent extends WsdlEvent
{

    protected $operation;

    public function __construct(Operation $operation, \DOMElement $node)
    {
        parent::__construct($node);
        $this->operation = $operation;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
}