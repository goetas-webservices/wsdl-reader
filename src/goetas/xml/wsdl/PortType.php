<?php
namespace goetas\xml\wsdl;

use goetas\xml\XMLDom;
use goetas\xml\XMLDomElement;
use InvalidArgumentException;
class PortType extends WsdlElement{
	protected $operations;
	public function __construct(Wsdl $wsdl, XMLDomElement $prt) {
		$ns = $prt->ownerDocument->documentElement->getAttribute("targetNamespace");
		parent::__construct($wsdl,$prt->getAttribute("name"),$ns);
		$operations = $prt->query("wsdl:operation");
		foreach ($operations as $operation){
			$this->operations[$operation->getAttribute("name")]=new Operation($wsdl, $this,$operation);
		}
	}
	/**
	 * @param string $name
	 * @return Operation
	 */
	public function getOperation($name) {
		return $this->operations[$name];
	}
	public function getOperations() {
		return $this->operations;
	}
	
}