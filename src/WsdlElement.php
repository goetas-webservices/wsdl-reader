<?php
namespace goetas\xml\wsdl;

use goetas\xml\XMLDom;
use goetas\xml\XMLDomElement;
use InvalidArgumentException;
abstract class WsdlElement {
	/**
	 * 
	 * @var XMLDomElement
	 */
	protected $data;
	/**
	 * @var Wsdl
	 */
	protected $wsdl;
	protected $name;
	public function __construct(Wsdl $wsdl, $name, $ns) {
		$this->wsdl = $wsdl;
		$this->name = $name;
		$this->ns = $ns;
	}
	/**
	 * 
	 * Get the wsdl
	 * @return Wsdl
	 */
	public function getWsdl() {
		return $this->wsdl;
	}
	public function getName() {
		return $this->name;
	}
	public function getNs() {
		return $this->ns;
	}
	/**
	 * 
	 * return XMLDomElement
	 */
	public function getDomElement() {
		return $this->data;
	}
}