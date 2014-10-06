<?php
namespace Goetas\XML\WSDLReader\Wsdl\Message;

use Goetas\XML\XSDReader\Schema\Type\Type;
use Goetas\XML\XSDReader\Schema\Element\ElementItem;
use Goetas\XML\WSDLReader\Wsdl\ExtensibleAttributesDocumented;
use Goetas\XML\WSDLReader\Wsdl\Message;
/**
 * XSD Type: tPart
 */
class Part extends ExtensibleAttributesDocumented
{
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\Message
     */
    protected $message;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \Goetas\XML\XSDReader\Schema\Element\ElementItem
     */
    protected $element;

    /**
     * @var \Goetas\XML\XSDReader\Schema\Type\Type
     */
    protected $type;

    public function __construct(Message $message, $name)
    {
        parent::__construct($message->getDefinition());

        $this->name = $name;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * @param $name string
     * @return \Goetas\XML\WSDLReader\Wsdl\Message\Part
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \Goetas\XML\XSDReader\Schema\Element\ElementItem
     */
    public function getElement()
    {
        return $this->element;
    }
    /**
     * @param $element string
     * @return \Goetas\XML\WSDLReader\Wsdl\Message\Part
     */
    public function setElement(ElementItem $element)
    {
        $this->element = $element;
        return $this;
    }


    /**
     * @return \Goetas\XML\XSDReader\Schema\Type\Type
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @param $type string
     * @return \Goetas\XML\WSDLReader\Wsdl\Message\Part
     */
    public function setType(Type $type)
    {
        $this->type = $type;
        return $this;
    }

}
