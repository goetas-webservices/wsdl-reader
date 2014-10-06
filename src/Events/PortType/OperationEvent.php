<?php
namespace Goetas\XML\WSDLReader\Events\PortType;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\PortType\Operation;
use Goetas\XML\WSDLReader\Events\NodeEvent;

class OperationEvent extends NodeEvent
{

    protected $operation;

    public function __construct(Operation $operation, \DOMElement $node)
    {
        parent::__construct($node);
        $this->operation = $operation;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
}