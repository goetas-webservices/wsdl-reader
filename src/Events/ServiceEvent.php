<?php
namespace Goetas\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\Service;

class ServiceEvent extends WsdlEvent
{
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Service
     */
    protected $Service;

    public function __construct(Service $Service, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Service = $Service;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Service
     */
    public function getService()
    {
        return $this->Service;
    }
}