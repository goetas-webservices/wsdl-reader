<?php
namespace Goetas\XML\WSDLReader\Wsdl;

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
     * @var string
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
