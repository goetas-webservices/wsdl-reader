<?php
namespace PhpWebservices\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\PortType;

class PortTypeEvent extends WsdlEvent
{
    /**
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\PortType
     */
    protected $PortType;

    public function __construct(PortType $PortType, \DOMElement $node)
    {
        parent::__construct($node);
        $this->PortType = $PortType;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType
     */
    public function getPortType()
    {
        return $this->PortType;
    }
}