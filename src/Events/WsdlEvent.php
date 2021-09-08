<?php
namespace GoetasWebservices\XML\WSDLReader\Events;

use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcherInterface;

if (interface_exists(PsrEventDispatcherInterface::class)) {
    abstract class WsdlEvent extends \Symfony\Contracts\EventDispatcher\Event
    {
        /**
         *
         * @var \DOMElement
         */
        protected $node;

        public function __construct(\DOMElement $node)
        {
            $this->node = $node;
        }

        /**
         * @return \DOMElement
         */
        public function getNode()
        {
            return $this->node;
        }
    }
} else {
    abstract class WsdlEvent extends \Symfony\Component\EventDispatcher\Event
    {
        /**
         *
         * @var \DOMElement
         */
        protected $node;

        public function __construct(\DOMElement $node)
        {
            $this->node = $node;
        }

        /**
         * @return \DOMElement
         */
        public function getNode()
        {
            return $this->node;
        }
    }
}
