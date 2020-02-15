<?php
namespace GoetasWebservices\XML\WSDLReader\Events;

use GoetasWebservices\XML\WSDLReader\Wsdl\Binding;

class BindingEvent extends WsdlEvent
{
    /**
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     */
    protected $Binding;

    public function __construct(Binding $Binding, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Binding = $Binding;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding()
    {
        return $this->Binding;
    }
}