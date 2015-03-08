<?php
namespace Goetas\XML\WSDLReader\Events\Message;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\Message\Part;
use Goetas\XML\WSDLReader\Events\WsdlEvent;

class PartEvent extends WsdlEvent
{
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Message\Part
     */
    protected $MessagePart;

    public function __construct(Part $MessagePart, \DOMElement $node)
    {
        parent::__construct($node);
        $this->MessagePart = $MessagePart;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Message\Part
     */
    public function getPart()
    {
        return $this->MessagePart;
    }
}