<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl;

/**
 * XSD Type: tMessage
 */
class Message extends ExtensibleDocumented
{

    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $part = array();

    public function __construct(Definitions $definition, $name)
    {
        parent::__construct($definition);

        $this->name = $name;
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
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $part \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function addPart(\GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part $part)
    {
        if ($part->getName()) {
            $this->part[$part->getName()] = $part;
        } else {
            $this->part[] = $part;
        }

        return $this;
    }
    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part[]
     */
    public function getParts()
    {
        return $this->part;
    }
    /**
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part
     */
    public function getPart($name)
    {
    	return $this->part[$name];
    }

}
