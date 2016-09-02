<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl\Service;

use GoetasWebservices\XML\WSDLReader\Wsdl\Binding;
use GoetasWebservices\XML\WSDLReader\Wsdl\ExtensibleDocumented;
use GoetasWebservices\XML\WSDLReader\Wsdl\Service;

/**
 * XSD Type: tPort
 */
class Port extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     */
    protected $binding;


    protected $service;

    public function __construct(Service $service, $name)
    {
        parent::__construct($service->getDefinition());
        $this->name = $name;
        $this->service = $service;
    }

    public function getService()
    {
        return $this->service;
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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Port
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding()
    {
        return $this->binding;
    }

    /**
     * @param $binding \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Port
     */
    public function setBinding(Binding $binding)
    {
        $this->binding = $binding;
        return $this;
    }

}
