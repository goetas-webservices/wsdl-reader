<?php
namespace goetas\xml\wsdl\xsd;
use goetas\xml\wsdl\Wsdl;
use goetas\xml\XMLDom;
use goetas\xml\XMLDomElement;
use InvalidArgumentException;
abstract class TypeDefinition {
	protected $name;
	protected $ns;
	public function __construct(Wsdl $wsdl, $ns, $name) {
		$this->name = $name;
		$this->ns = $ns;
	}
	public function getNs() {
		return $this->ns;
	}
	public function getName() {
		return $this->name;
	}
	public function __toString() {
		return "{{$this->ns}}#$this->name";
	}
}