<?php
namespace Goetas\XML\WSDLReader\Wsdl;

use Goetas\XML\XSDReader\Schema\Type\Type;
use Goetas\XML\XSDReader\Schema\Element\ElementItem;
/**
 * XSD Type: tPart
 */
class Part extends ExtensibleAttributesDocumented
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $element;

    /**
     * @var string
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
     * @return \Goetas\XML\WSDLReader\Wsdl\Part
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
     * @return \Goetas\XML\WSDLReader\Wsdl\Part
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
     * @return \Goetas\XML\WSDLReader\Wsdl\Part
     */
    public function setType(Type $type)
    {
        $this->type = $type;
        return $this;
    }

}
