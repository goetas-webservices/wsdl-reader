<?php
namespace PhpWebservices\XML\WSDLReader\Events\Binding;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\Binding\Operation;
use PhpWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage;
use PhpWebservices\XML\WSDLReader\Events\WsdlEvent;

class MessageEvent extends WsdlEvent
{

    protected $Fault;

    public function __construct(OperationMessage $Fault, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Fault = $Fault;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage
     */
    public function getOperationMessage()
    {
        return $this->Fault;
    }
}

