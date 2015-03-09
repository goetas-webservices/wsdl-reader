<?php
namespace PhpWebservices\XML\WSDLReader\Wsdl\Service;

use PhpWebservices\XML\WSDLReader\Wsdl\ExtensibleDocumented;
use PhpWebservices\XML\WSDLReader\Wsdl\Service;
use PhpWebservices\XML\WSDLReader\Wsdl\Binding;
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
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\Binding
     */
    protected $binding;


    protected $service;

    public function __construct(Service $service, $name)
    {
        parent::__construct($service->getDefinition());
        $this->name = $name;
        $this->service = $service;
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
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Port
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding()
    {
        return $this->binding;
    }
    /**
     * @param $binding \PhpWebservices\XML\WSDLReader\Wsdl\Binding
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Port
     */
    public function setBinding(Binding $binding)
    {
        $this->binding = $binding;
        return $this;
    }

}
