<?php
namespace PhpWebservices\XML\WSDLReader\Events;

use Symfony\Component\EventDispatcher\Event;
use PhpWebservices\XML\WSDLReader\Wsdl\Definitions;

class DefinitionsEvent extends WsdlEvent
{
    /**
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\Definitions
     */
    protected $definitions;

    public function __construct(Definitions $definitions, \DOMElement $node)
    {
        parent::__construct($node);
        $this->definitions = $definitions;
    }

    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Definitions
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }
}