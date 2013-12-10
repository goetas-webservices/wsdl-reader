<?php
namespace goetas\xml\wsdl;

use goetas\xml\XMLDomElement;
class Port extends WsdlElement
{
    /**
     * @var Binding
     */
    protected $binding;

    protected $data;

    public function __construct(Service $service, XMLDomElement $bind)
    {
        parent::__construct($service->getWsdl(),$bind->getAttribute("name"), $service->getNs());
        $this->data = $bind;

        list($prefix, $name) = explode(":", $bind->getAttribute("binding"));
        $ns  = $bind->lookupNamespaceURI($prefix);

        $this->binding = $service->getWsdl()->getBinding($ns, $name);

    }
    public function getDomElement()
    {
        return $this->data;
    }
    /**
     *
     * @return Binding
     */
    public function getBinding()
    {
        return $this->binding;
    }
}
