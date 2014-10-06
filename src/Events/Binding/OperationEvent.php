<?php
namespace Goetas\XML\WSDLReader\Events\Binding;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\Binding\Operation;
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
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
}