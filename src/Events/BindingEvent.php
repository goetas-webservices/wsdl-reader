<?php
namespace Goetas\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\Binding;

class BindingEvent extends NodeEvent
{
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    protected $Binding;

    public function __construct(Binding $Binding, \DOMElement $node)
    {
        parent::__construct($node);
        $this->Binding = $Binding;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding()
    {
        return $this->Binding;
    }
}