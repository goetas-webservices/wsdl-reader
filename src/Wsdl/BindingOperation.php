<?php
namespace Goetas\XML\WSDLReader\Wsdl;

use goetas\xml\XMLDomElement;
class BindingOperation extends WsdlElement
{
    /**
     * @var Operation
     */
    protected $operation;
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\BindingMessage
     */
    protected $input;
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\BindingMessage
     */
    protected $output;
    /**
     * @var \Goetas\XML\WSDLReader\Wsdl\BindingMessage[]
     */
    protected $faults;

    /**
     * @var Binding
     */
    protected $binding;

    public function __construct(Binding $binding, XMLDomElement $bind)
    {
        parent::__construct($binding->getWsdl(),$bind->getAttribute("name"), $binding->getNs());
        $this->data = $bind;
        $this->binding = $binding;

        $this->operation = $binding->getPortType()->getOperation($this->getName());

        $parts = $bind->query("wsdl:input|wsdl:output|wsdl:fault", array("wsdl"=>Wsdl::WSDL_NS));

        foreach ($parts as $part) {
            switch ($part->localName) {
                case "input":
                    $this->input = new BindingMessage($this->operation->getInput(),$part);
                break;
                case "output":
                    $this->output = new BindingMessage($this->operation->getOutput(),$part);
                break;
            }
        }
    }
    public function __toString()
    {
        $s = "BindingOperation: ";
        if ($this->output) {
            $s.=$this->output->getName();
            $s .= " ";
        }
        $s .= $this->operation->getName();
        $s .= "(";
        if ($this->input) {
            $s.=$this->input->getName();
        }
        $s .= ")";

        return $s;
    }
    /**
     *
     * @return \Goetas\XML\WSDLReader\Wsdl\Binding
     */
    public function getBinding()
    {
        return $this->binding;
    }
    public function getDomElement()
    {
        return $this->data;
    }
    /**
     *
     * @return \Goetas\XML\WSDLReader\Wsdl\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingMessage
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingMessage
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * @return \Goetas\XML\WSDLReader\Wsdl\BindingMessage[]
     */
    public function getFaults()
    {
        return $this->output;
    }
}
