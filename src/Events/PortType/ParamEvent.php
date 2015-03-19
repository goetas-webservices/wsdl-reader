<?php
namespace GoetasWebservices\XML\WSDLReader\Events\PortType;

use Symfony\Component\EventDispatcher\Event;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Operation;
use GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param;
use GoetasWebservices\XML\WSDLReader\Events\WsdlEvent;

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