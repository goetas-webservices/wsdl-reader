<?php
namespace GoetasWebservices\XML\WSDLReader\Events;

use GoetasWebservices\XML\WSDLReader\Wsdl\Definitions;
use Symfony\Component\EventDispatcher\Event;

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