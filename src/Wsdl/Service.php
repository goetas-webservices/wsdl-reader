<?php
namespace Goetas\XML\WSDLReader\Wsdl;

/**
 * XSD Type: tService
 */
class Service extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $port = array();



    public function __construct(Definitions $def, $name)
    {
        parent::__construct($def);
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param $name string
     * @return \Goetas\XML\WSDLReader\Wsdl\Service
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }



    /**
     * @param $port \Goetas\XML\WSDLReader\Wsdl\Port
     */
    public function addPort(\Goetas\XML\WSDLReader\Wsdl\Port $port)
    {
        $this->port[$port->getName()] = $port;
        return $this;
    }
    public function getPort($name)
    {
        return $this->port[$name];
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Port[]
     */
    public function getPorts()
    {
        return $this->port;
    }
    /**
     * @param $port \Goetas\XML\WSDLReader\Wsdl\Port[]
     * @return \Goetas\XML\WSDLReader\Wsdl\Service
     */
    public function setPort(array $port)
    {
        foreach ($port as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\Port) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\Port');
            }
        }
        $this->port = $port;
        return $this;
    }
}
