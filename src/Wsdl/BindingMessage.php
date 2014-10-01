<?php
namespace Goetas\XML\WSDLReader\Wsdl;

use goetas\xml\XMLDomElement;
class BindingMessage extends WsdlElement
{
    /**
     * @var Message
     */
    protected $message;
    protected $data;
    public function __construct(Message $message, XMLDomElement $xml)
    {
        parent::__construct($message->getWsdl(),$xml->getAttribute("name"), $message->getNs());
        $this->data = $xml;
        $this->message = $message;
    }
    /**
     * @return \goetas\xml\XMLDomElement
     */
    public function getDomElement()
    {
        return $this->data;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Message
     */
    public function getMessage()
    {
        return $this->message;
    }

}
