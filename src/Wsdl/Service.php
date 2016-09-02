<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl;
use GoetasWebservices\XML\WSDLReader\Exception\PortNotFoundException;

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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Service
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @param $port \GoetasWebservices\XML\WSDLReader\Wsdl\Service\Port
     */
    public function addPort(\GoetasWebservices\XML\WSDLReader\Wsdl\Service\Port $port)
    {
        $this->port[$port->getName()] = $port;
        return $this;
    }

    public function getPort($name)
    {
        if (isset($this->port[$name])){
            return $this->port[$name];
        }
        throw new PortNotFoundException("The port named $name can not be found inside $this->name");
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Service\Port[]
     */
    public function getPorts()
    {
        return $this->port;
    }

}
