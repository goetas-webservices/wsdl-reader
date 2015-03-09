<?php
namespace PhpWebservices\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\Message;

class MessageEvent extends WsdlEvent
{
    /**
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\Message
     */
    protected $Message;

    public function __construct(Message $Message, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Message = $Message;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Message
     */
    public function getMessage()
    {
        return $this->Message;
    }
}