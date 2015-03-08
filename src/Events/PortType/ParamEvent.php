<?php
namespace Goetas\XML\WSDLReader\Events\PortType;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\PortType\Operation;
use Goetas\XML\WSDLReader\Wsdl\PortType\Param;
use Goetas\XML\WSDLReader\Events\WsdlEvent;

class ParamEvent extends WsdlEvent
{

    protected $param;

    public function __construct(Param $param, \DOMElement $node)
    {
        parent::__construct($node);
        $this->param = $param;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function getParam()
    {
        return $this->param;
    }
}