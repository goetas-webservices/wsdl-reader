<?php
namespace Goetas\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;

abstract class WsdlEvent extends Event
{
    /**
     *
     * @var \DOMElement
     */
    protected $node;

    public function __construct(\DOMElement $node)
    {
        $this->node = $node;
    }
    /**
     * @return \DOMElement
     */
    public function getNode()
    {
        return $this->node;
    }
}