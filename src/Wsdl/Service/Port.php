<?php
namespace Goetas\XML\WSDLReader\Wsdl\Service;

use Goetas\XML\WSDLReader\Wsdl\ExtensibleDocumented;
use Goetas\XML\WSDLReader\Wsdl\Service;
use Goetas\XML\WSDLReader\Wsdl\Binding;
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
     * @var \Goetas\XML\WSDLReader\Wsdl\Binding
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
     * @return \Goetas\XML\WSDLReader\Wsdl\Port
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding()
    {
        return $this->binding;
    }
    /**
     * @param $binding \Goetas\XML\WSDLReader\Wsdl\Binding
     * @return \Goetas\XML\WSDLReader\Wsdl\Port
     */
    public function setBinding(Binding $binding)
    {
        $this->binding = $binding;
        return $this;
    }

}
