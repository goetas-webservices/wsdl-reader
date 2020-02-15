<?php
namespace GoetasWebservices\XML\WSDLReader\Events;

use GoetasWebservices\XML\WSDLReader\Wsdl\PortType;

class PortTypeEvent extends WsdlEvent
{
    /**
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\PortType
     */
    protected $PortType;

    public function __construct(PortType $PortType, \DOMElement $node)
    {
        parent::__construct($node);
        $this->PortType = $PortType;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType
     */
    public function getPortType()
    {
        return $this->PortType;
    }
}