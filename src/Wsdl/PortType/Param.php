<?php
namespace PhpWebservices\XML\WSDLReader\Wsdl\PortType;

use PhpWebservices\XML\WSDLReader\Wsdl\ExtensibleAttributesDocumented;
use PhpWebservices\XML\WSDLReader\Wsdl\Message;
/**
 * XSD Type: tParam
 */
class Param extends ExtensibleAttributesDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $message;

    protected $operation;


    public function __construct(Operation $operation, $name)
    {
        parent::__construct($operation->getDefinition());

        $this->name = $name;
        $this->operation = $operation;
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
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }


    /**
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\Message
     */
    public function getMessage()
    {
        return $this->message;
    }
    /**
     * @param $message string
     * @return \PhpWebservices\XML\WSDLReader\Wsdl\PortType\Param
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;
        return $this;
    }

}
