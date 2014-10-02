<?php
namespace Goetas\XML\WSDLReader\Wsdl;

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
     * @return string
     */
    public function getElement()
    {
        return $this->element;
    }
    /**
     * @param $element string
     * @return \Goetas\XML\WSDLReader\Wsdl\Part
     */
    public function setElement($element)
    {
        $this->element = $element;
        return $this;
    }


    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
    /**
     * @param $type string
     * @return \Goetas\XML\WSDLReader\Wsdl\Part
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

}
