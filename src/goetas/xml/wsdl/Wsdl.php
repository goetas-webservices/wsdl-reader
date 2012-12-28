<?php 
namespace goetas\xml\wsdl;
use goetas\xml\xsd\SchemaContainer;

use goetas\xml\wsdl\utils\UrlUtils;

use goetas\xml\XPath;
use goetas\xml\utils;
use goetas\xml\XMLDom;
use InvalidArgumentException;
class Wsdl  {
	protected $options = array();
	protected $parsedXsd = array();
	protected $parsedWsdl = array();
	protected $portTypes = array();
	protected $bindings = array();
	protected $operations = array();
	protected $services = array();
	protected $elements = array();
	protected $messages = array();		
	protected $schemaNodes = array();
		
	protected $schemaContainer;
	
	const WSDL_NS = 'http://schemas.xmlsoap.org/wsdl/';
	const XSD_NS = 'http://www.w3.org/2001/XMLSchema';
	/**
	 * limita un problema di PHP, ovvero la possibilta ritirare proprieta non definite nella classe
	 */
	public function __get($p){
		throw new \Exception("proprietà {$p} non definita in ".get_class($this));
	}
	/**
	 * limita un problema di PHP, ovvero la possibilta di settare proprieta non definite nella classe
	 */
	public function __set($p,$v){
		throw new \Exception("proprietà {$p} non definita in ".get_class($this));
	}
	public function __construct($path, array $options = array()) {
		
		$this->options = (object)$options;
		
		
		$this->schemaContainer = new SchemaContainer();
	
		if(!isset($this->options->cache)){ 
			$this->options->cache = 3600;
		}
		
		$this->loadWsdl($path);
		$this->parseWsdl();
	}
	public function getSchemaContainer() {
		return $this->schemaContainer;
	}
	protected function parseWsdl() {
		foreach ($this->parsedWsdl as $wsdl){
			$xp = new XPath($wsdl);
			$xp->registerNamespace("wsdl", self::WSDL_NS);
			$xp->registerNamespace("xsd", self::XSD_NS);
			
			
			$schemas = $xp->query("/wsdl:definitions/wsdl:types/xsd:schema");
			foreach ($schemas as $schema){
				$this->schemaContainer->addSchemaNode($schema);
			}
			
			
			$msgs = $xp->query("/wsdl:definitions/wsdl:message");
			foreach ($msgs as $msg){
				$this->messages[$wsdl->documentElement->getAttribute("targetNamespace")][$msg->getAttribute("name")]=new Message($this, $msg);
			}
			
			$ports = $xp->query("/wsdl:definitions/wsdl:portType");
			foreach ($ports as $port){
				$this->portTypes[$wsdl->documentElement->getAttribute("targetNamespace")][$port->getAttribute("name")]=new PortType($this, $port);
			}
			$bindings = $xp->query("/wsdl:definitions/wsdl:binding");
			foreach ($bindings as $binding){
				$this->bindings[$wsdl->documentElement->getAttribute("targetNamespace")][$binding->getAttribute("name")]=new Binding($this, $binding);
			}
			
			$services = $xp->query("/wsdl:definitions/wsdl:service");
			foreach ($services as $service){
				$this->services[$wsdl->documentElement->getAttribute("targetNamespace")][$service->getAttribute("name")]=new Service($this, $service);
			}
			
		}
	}

	protected function getXML($path) {
		$tmpPath = sys_get_temp_dir()."/wsdl".md5($path).".xml";
		$xml = new XMLDom();
		if(!$this->options->cache || !is_file($tmpPath) || (time()-$this->options->cache) > filemtime($tmpPath) ){
			$cnt = file_get_contents($path);
			if($cnt){
				file_put_contents($tmpPath, $cnt);
			}
		}
		$xml->loadXMLStrictFile($tmpPath);
		$xml->documentURI = $path;
		return $xml;
	}
	protected function loadWsdl($path) {
				
		$xml = $this->getXML($path);
		
		$ns = $xml->documentElement->getAttribute("targetNamespace");
		
	
		$this->parsedWsdl[$ns]=$xml;
		
		$xp = new XPath($xml);
		$xp->registerNamespace("wsdl", self::WSDL_NS);
					
		$imports = $xp->query("/wsdl:definitions/wsdl:import[@location]");
		foreach ($imports as $import){
			$relPath = UrlUtils::resolve_url($path,$import->getAttribute("location"));
			$ns = $import->getAttribute("namespace");
			
			if(!$this->parsedWsdl[$ns]){
				$this->loadWsdl($relPath);
			}
		}
	}
	public function getOperations() {
		return $this->operations;
	}
	public function getServices() {
		return $this->services;
	}
	public function getMessage($ns, $name) {
		return $this->messages[$ns][$name];
	}
	public function getPortTypes() {
		return $this->portTypes;
	}
	public function getPortType($ns, $name) {
		if(isset($this->portTypes[$ns][$name])){
			return $this->portTypes[$ns][$name];
		}
		throw new InvalidArgumentException("Non trovo il portType [$ns][$name]");
	}
	public function getBinding($ns, $name) {
		if(isset($this->bindings[$ns][$name])){
			return $this->bindings[$ns][$name];
		}
		throw new InvalidArgumentException("Non trovo il bindings [$ns][$name]");
	}
	
}