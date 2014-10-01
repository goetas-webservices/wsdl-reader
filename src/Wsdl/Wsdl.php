<?php
namespace Goetas\XML\WSDLReader\Wsdl;

use InvalidArgumentException;

class Wsdl
{
    protected $wsdl = array();

    protected $portTypes = array();

    protected $bindings = array();

    protected $operations = array();

    protected $services = array();

    protected $elements = array();

    protected $messages = array();

    public function __construct($path)
    {
        $this->schemaContainer = new SchemaContainer();
    }

    public function getSchemaContainer()
    {
        return $this->schemaContainer;
    }

    public function getOperations()
    {
        return $this->operations;
    }

    public function getServices()
    {
        return $this->services;
    }

    public function getMessage($ns, $name)
    {
        if (isset($this->messages[$ns][$name])) {
            return $this->messages[$ns][$name];
        }
        throw new InvalidArgumentException("Non trovo il message [$ns][$name]");
    }

    public function getPortTypes()
    {
        return $this->portTypes;
    }

    public function getPortType($ns, $name)
    {
        if (isset($this->portTypes[$ns][$name])) {
            return $this->portTypes[$ns][$name];
        }
        throw new InvalidArgumentException("Non trovo il portType [$ns][$name]");
    }

    public function getBinding($ns, $name)
    {
        if (isset($this->bindings[$ns][$name])) {
            return $this->bindings[$ns][$name];
        }
        throw new InvalidArgumentException("Non trovo il bindings [$ns][$name]");
    }
}
