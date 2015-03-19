<?php
namespace GoetasWebservices\XML\WSDLReader\Events\Service;

use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;
use GoetasWebservices\XML\WSDLReader\Wsdl\Service\Port;

class PortEvent extends WsdlEvent
{

    protected $port;

    public function __construct(Port $port, \DOMElement $node)
    {
        parent::__construct($node);
        $this->port = $port;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Service\Port
     */
    public function getPort()
    {
        return $this->port;
    }
}