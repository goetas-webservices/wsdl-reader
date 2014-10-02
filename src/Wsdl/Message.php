<?php
namespace Goetas\XML\WSDLReader\Wsdl;

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
     * @return \Goetas\XML\WSDLReader\Wsdl\Message
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }



    /**
     * @param $part \Goetas\XML\WSDLReader\Wsdl\Part
     */
    public function addPart(\Goetas\XML\WSDLReader\Wsdl\Part $part)
    {
        $this->part[] = $part;
        return $this;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\Part[]
     */
    public function getPart()
    {
        return $this->part;
    }
    /**
     * @param $part \Goetas\XML\WSDLReader\Wsdl\Part[]
     * @return \Goetas\XML\WSDLReader\Wsdl\Message
     */
    public function setPart(array $part)
    {
        foreach ($part as $item) {
            if (!($item instanceof \Goetas\XML\WSDLReader\Wsdl\Part) ) {
                throw new \InvalidArgumentException('Argument 1 passed to ' . __METHOD__ . ' be an array of \Goetas\XML\WSDLReader\Wsdl\Part');
            }
        }
        $this->part = $part;
        return $this;
    }

}
