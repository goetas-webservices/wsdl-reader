<?php
namespace goetas\xml\wsdl;

use goetas\xml\XMLDomElement;
use InvalidArgumentException;
class Message extends WsdlElement
{
    /**
     *
     * @var XMLDomElement
     */
    protected $data;
    protected $parts=array();
    public function __construct(Wsdl $wsdl, XMLDomElement $msg)
    {
        $ns = $msg->ownerDocument->documentElement->getAttribute("targetNamespace");
        parent::__construct($wsdl, $msg->getAttribute("name"), $ns);
        $parts =  $msg->query("wsdl:part", array("wsdl"=>Wsdl::WSDL_NS));
        foreach ($parts as $part) {
            $this->parts[$part->getAttribute("name")]=new MessagePart($this, $part);
        }
        $this->data = $msg;
    }
    /**
     * @return MessagePart[]
     */
    public function getParts()
    {
        return $this->parts;
    }
    /**
     *
     * @param  string                       $name
     * @throws InvalidArgumentException
     * @return \goetas\xml\wsdl\MessagePart
     */
    public function getPart($name)
    {
        if (isset($this->parts[$name])) {
            return $this->parts[$name];
        }
        throw new InvalidArgumentException("Non trovo il message part [$name]");
    }
    /**
     *
     * return XMLDomElement
     */
    public function getDomElement()
    {
        return $this->data;
    }

}
