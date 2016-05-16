<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl\Message;

use GoetasWebservices\XML\WSDLReader\Wsdl\ExtensibleAttributesDocumented;
use GoetasWebservices\XML\WSDLReader\Wsdl\Message;
use GoetasWebservices\XML\XSDReader\Schema\Element\ElementItem;
use GoetasWebservices\XML\XSDReader\Schema\Type\Type;

/**
 * XSD Type: tPart
 */
class Part extends ExtensibleAttributesDocumented
{
    /**
     * @var \GoetasWebservices\XML\WSDLReader\Wsdl\Message
     */
    protected $message;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \GoetasWebservices\XML\XSDReader\Schema\Element\ElementItem
     */
    protected $element;

    /**
     * @var \GoetasWebservices\XML\XSDReader\Schema\Type\Type
     */
    protected $type;

    public function __construct(Message $message, $name)
    {
        parent::__construct($message->getDefinition());

        $this->name = $name;
        $this->message = $message;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \GoetasWebservices\XML\XSDReader\Schema\Element\ElementItem
     */
    public function getElement()
    {
        return $this->element;
    }

    /**
     * @param $element string
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function setElement(ElementItem $element)
    {
        $this->element = $element;
        return $this;
    }


    /**
     * @return \GoetasWebservices\XML\XSDReader\Schema\Type\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param $type string
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function setType(Type $type)
    {
        $this->type = $type;
        return $this;
    }

}
