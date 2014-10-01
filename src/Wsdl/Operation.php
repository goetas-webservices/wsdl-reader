<?php
namespace Goetas\XML\WSDLReader\Wsdl;

use goetas\xml\XMLDomElement;
class Operation extends WsdlElement
{
    /**
     * @var Message
     */
    protected $input;
    /**
     * @var Message
     */
    protected $output;
    /**
     * @var Message
     */
    protected $faults;

    protected $ns;
    public function __construct(Wsdl $wsdl, PortType $port, XMLDomElement $operation)
    {
        parent::__construct($wsdl,$operation->getAttribute("name"), $port->getNs());
        foreach (array("input", "output") as $typeMessage) {
            $r = $operation->query("wsdl:$typeMessage", array("wsdl"=>Wsdl::WSDL_NS));
            if ($r->length) {
                list($prefix, $name) = explode(":", $r->item(0)->getAttribute("message"));
                $ns  = $operation->lookupNamespaceURI($prefix);
                $this->{$typeMessage} = $wsdl->getMessage($ns, $name);
            }
        }

        $faults = $operation->query("wsdl:fault", array("wsdl"=>Wsdl::WSDL_NS));
        foreach ($faults as $fault) {
            list($prefix, $name) = explode(":", $fault->getAttribute("message"));
            $ns  = $fault->lookupNamespaceURI($prefix);
            $this->faults[] = $wsdl->getMessage($ns, $name);
        }
        $this->ns = $operation->evaluate("string(ancestor::wsdl:definitions/@targetNamespace)", array("wsdl"=>Wsdl::WSDL_NS));

    }
    public function getNs()
    {
        return $this->ns;
    }
    /**
     * @return Message
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @return Output
     */
    public function getOutput()
    {
        return $this->output;
    }
}
