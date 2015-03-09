<?php
namespace PhpWebservices\XML\WSDLReader\Events\Message;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\Message\Part;
use PhpWebservices\XML\WSDLReader\Events\WsdlEvent;

class PartEvent extends WsdlEvent
{
    /**
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    protected $MessagePart;

    public function __construct(Part $MessagePart, \DOMElement $node)
    {
        parent::__construct($node);
        $this->MessagePart = $MessagePart;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function getPart()
    {
        return $this->MessagePart;
    }
}