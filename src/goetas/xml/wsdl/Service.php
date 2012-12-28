<?php
namespace goetas\xml\wsdl;

use goetas\xml\XMLDom;
use goetas\xml\XMLDomElement;
use InvalidArgumentException;
class Service extends WsdlElement{
	protected $ports;
	public function __construct(Wsdl $wsdl, XMLDomElement $service) {
		$ns = $service->ownerDocument->documentElement->getAttribute("targetNamespace");
		parent::__construct($wsdl,$service->getAttribute("name"),$ns);
		$ports = $service->query("wsdl:port");
		foreach ($ports as $port){
			$this->ports[$port->getAttribute("name")]=new Port($this, $port);
		}
	}
	public function getPort($name) {
		return $this->ports[$name];
	}
	public function getPorts() {
		return $this->ports;
	}	
}