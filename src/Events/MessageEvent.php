<?php
namespace Goetas\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\Message;

class MessageEvent extends NodeEvent
{
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Message
     */
    protected $Message;

    public function __construct(Message $Message, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Message = $Message;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Message
     */
    public function getMessage()
    {
        return $this->Message;
    }
}