<?php
namespace PhpWebservices\XML\WSDLReader\Wsdl\Message;

use PhpWebservices\XML\XSDReader\Schema\Type\Type;
use PhpWebservices\XML\XSDReader\Schema\Element\ElementItem;
use PhpWebservices\XML\WSDLReader\Wsdl\ExtensibleAttributesDocumented;
use PhpWebservices\XML\WSDLReader\Wsdl\Message;
/**
 * XSD Type: tPart
 */
class Part extends ExtensibleAttributesDocumented
{
    /**
     * @var \PhpWebservices\XML\WSDLReader\Wsdl\Message
     */
    protected $message;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \PhpWebservices\XML\XSDReader\Schema\Element\ElementItem
     */
    protected $element;

    /**
     * @var \PhpWebservices\XML\XSDReader\Schema\Type\Type
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
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \PhpWebservices\XML\XSDReader\Schema\Element\ElementItem
     */
    public function getElement()
    {
        return $this->element;
    }
    /**
     * @param $element string
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function setElement(ElementItem $element)
    {
        $this->element = $element;
        return $this;
    }


    /**
     * @return \PhpWebservices\XML\XSDReader\Schema\Type\Type
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @param $type string
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function setType(Type $type)
    {
        $this->type = $type;
        return $this;
    }

}
