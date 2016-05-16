<?php
namespace GoetasWebservices\XML\WSDLReader\Events\PortType;

use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param;
use Symfony\Component\EventDispatcher\Event;

class ParamEvent extends WsdlEvent
{

    protected $param;

    public function __construct(Param $param, \DOMElement $node)
    {
        parent::__construct($node);
        $this->param = $param;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function getParam()
    {
        return $this->param;
    }
}