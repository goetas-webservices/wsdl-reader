<?php
namespace PhpWebservices\XML\WSDLReader\Events\PortType;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\PortType\Operation;
use PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param;
use PhpWebservices\XML\WSDLReader\Events\WsdlEvent;

class ParamEvent extends WsdlEvent
{

    protected $param;

    public function __construct(Param $param, \DOMElement $node)
    {
        parent::__construct($node);
        $this->param = $param;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function getParam()
    {
        return $this->param;
    }
}