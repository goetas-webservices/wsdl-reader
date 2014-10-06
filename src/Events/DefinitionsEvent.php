<?php
namespace Goetas\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use Goetas\XML\WSDLReader\Wsdl\Definitions;

class DefinitionsEvent extends NodeEvent
{
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Definitions
     */
    protected $definitions;

    public function __construct(Definitions $definitions, \DOMElement $node)
    {
        parent::__construct($node);
        $this->definitions = $definitions;
    }

    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Definitions
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}