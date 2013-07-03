<?php
namespace goetas\xml\wsdl;

use goetas\xml\XMLDom;
use goetas\xml\XMLDomElement;
use InvalidArgumentException;
class BindingMessage extends WsdlElement{
	/**
	 * @var Message
	 */
	protected $message;
	protected $data;
	public function __construct(Message $message, XMLDomElement $xml) {
		parent::__construct($message->getWsdl(),$xml->getAttribute("name"), $message->getNs());
		$this->data = $xml;
		$this->message = $message;
	}
	/**
	 * @return \goetas\xml\XMLDomElement
	 */
	public function getDomElement() {
		return $this->data;
	}
	/**
	 * @return \goetas\xml\wsdl\Message
	 */
	public function getMessage() {
		return $this->message;
	}

}