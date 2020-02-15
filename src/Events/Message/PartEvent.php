<?php
namespace GoetasWebservices\XML\WSDLReader\Events\Message;

use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;
use GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part;

class PartEvent extends WsdlEvent
{
    /**
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    protected $MessagePart;

    public function __construct(Part $MessagePart, \DOMElement $node)
    {
        parent::__construct($node);
        $this->MessagePart = $MessagePart;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function getPart()
    {
        return $this->MessagePart;
    }
}