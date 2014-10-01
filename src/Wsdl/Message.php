<?php
namespace Goetas\XML\WSDLReader\Wsdl;

use goetas\xml\XMLDomElement;
use InvalidArgumentException;
class Message extends WsdlElement
{
    protected $name;
    protected $parts=array();
    public function __construct(Wsdl $wsdl)
    {
        parent::__construct($wsdl);
        $this->name = $name;
    }

    public function addPart(MessagePart $part) {
        $this->parts[$part->getName()]=$part;
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
     * @return \Goetas\XML\WSDLReader\Wsdl\MessagePart
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
