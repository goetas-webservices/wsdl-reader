<?php
namespace goetas\xml\wsdl;

use goetas\xml\XMLDomElement;
class Binding extends WsdlElement
{
    protected $operations = array();
    protected $data;
    /**
     * @var PortType
     */
    protected $portType;
    public function getType()
    {
        ;
    }
    public function __construct(Wsdl $wsdl, XMLDomElement $bind)
    {
        $ns = $bind->ownerDocument->documentElement->getAttribute("targetNamespace");
        parent::__construct($wsdl,$bind->getAttribute("name"), $ns);
        $this->data = $bind;
        list($prefix, $name) = explode(":", $bind->getAttribute("type"));
        $ns  = $bind->lookupNamespaceURI($prefix);

        $this->portType = $wsdl->getPortType($ns, $name);

        $operations = $bind->query("wsdl:operation");
        foreach ($operations as $operation) {
            $this->operations[$operation->getAttribute("name")]=new BindingOperation($this, $operation);
        }
    }
    public function getDomElement()
    {
        return $this->data;
    }
    /**
     *
     * @return PortType
     */
    public function getPortType()
    {
        return $this->portType;
    }
    /**
     * @param $name
     * @throws Exception
     * @return BindingOperation
     */
    public function getOperation($name)
    {
        if (!$name) {
            throw new Exception("Operazione non valida su Binding '".$this->getName()."'");
        }
        if (!isset($this->operations[$name])) {
            throw new Exception("Non trovo l'operazione '$name' su Binding '".$this->getName()."'");
        }

        return $this->operations[$name];
    }
    public function getOperations()
    {
        return $this->operations;
    }
}
