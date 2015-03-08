<?php
namespace Goetas\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\PortType;

class PortTypeEvent extends WsdlEvent
{
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\PortType
     */
    protected $PortType;

    public function __construct(PortType $PortType, \DOMElement $node)
    {
        parent::__construct($node);
        $this->PortType = $PortType;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType
     */
    public function getPortType()
    {
        return $this->PortType;
    }
}