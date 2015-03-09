<?php
namespace PhpWebservices\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\Service;

class ServiceEvent extends WsdlEvent
{
    /**
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\Service
     */
    protected $Service;

    public function __construct(Service $Service, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Service = $Service;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Service
     */
    public function getService()
    {
        return $this->Service;
    }
}