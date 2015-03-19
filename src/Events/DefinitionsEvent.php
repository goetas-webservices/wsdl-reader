<?php
namespace GoetasWebservices\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use GoetasWebservices\XML\WSDLReader\Wsdl\Definitions;

class DefinitionsEvent extends WsdlEvent
{
    /**
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\Definitions
     */
    protected $definitions;

    public function __construct(Definitions $definitions, \DOMElement $node)
    {
        parent::__construct($node);
        $this->definitions = $definitions;
    }

    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Definitions
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}