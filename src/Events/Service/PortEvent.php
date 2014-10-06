<?php
namespace Goetas\XML\WSDLReader\Events\Service;

use Goetas\XML\WSDLReader\Events\NodeEvent;
use Goetas\XML\WSDLReader\Wsdl\Service\Port;

class PortEvent extends NodeEvent
{

    protected $port;

    public function __construct(Port $port, \DOMElement $node)
    {
        parent::__construct($node);
        $this->port = $port;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Service\Port
     */
    public function getPort()
    {
        return $this->port;
    }
}