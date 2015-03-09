<?php
namespace PhpWebservices\XML\WSDLReader\Events\PortType;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\PortType\Operation;
use PhpWebservices\XML\WSDLReader\Events\WsdlEvent;

class OperationEvent extends WsdlEvent
{

    protected $operation;

    public function __construct(Operation $operation, \DOMElement $node)
    {
        parent::__construct($node);
        $this->operation = $operation;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
}