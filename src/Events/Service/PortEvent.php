<?php
namespace PhpWebservices\XML\WSDLReader\Events\Service;

use PhpWebservices\XML\WSDLReader\Events\WsdlEvent;
use PhpWebservices\XML\WSDLReader\Wsdl\Service\Port;

class PortEvent extends WsdlEvent
{

    protected $port;

    public function __construct(Port $port, \DOMElement $node)
    {
        parent::__construct($node);
        $this->port = $port;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Service\Port
     */
    public function getPort()
    {
        return $this->port;
    }
}