<?php
namespace Goetas\XML\WSDLReader\Wsdl;

use goetas\xml\xsd\Element;
use goetas\xml\xsd\Type;
use goetas\xml\XMLDomElement;
class MessagePart extends WsdlElement
{
    /**
     * @var \goetas\xml\xsd\Type
     */
    protected $type;
    /**
     *
     * @var \goetas\xml\xsd\Element
     */
    protected $element;

    public function __construct(Message $message, XMLDomElement $msg)
    {
        parent::__construct ( $message->getWsdl(), $msg->getAttribute ( "name" ) , $message->getNs());
        if ($msg->hasAttribute ( "type" )) {
            list ( $prefix, $name ) = explode ( ":", $msg->getAttribute ( "type" ) );
            $ns = $msg->lookupNamespaceURI ( $prefix );
            $this->type = array ( $ns, $name );
        }
        if ($msg->hasAttribute ( "element" )) {
            list ( $prefix, $name ) = explode ( ":", $msg->getAttribute ( "element" ) );
            $ns = $msg->lookupNamespaceURI ( $prefix );
            $this->element = array ( $ns, $name );
        }
        $this->data = $msg;
    }
    public function __toString()
    {
        if ($this->isElement()) {
            return "Element: ".$this->element;
        } else {
            return "Type: ".$this->type;
        }
    }
    /**
     *
     * @var \goetas\xml\xsd\Element
     */
    public function getElement()
    {
        return $this->element;
    }
    /**
     *
     * @var \goetas\xml\xsd\Type
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @return bool
     */
    public function isElement()
    {
        return $this->element?true:false;
    }
    /**
     * @return bool
     */
    public function isType()
    {
        return $this->type?true:false;
    }
}
