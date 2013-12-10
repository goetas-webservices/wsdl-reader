<?php
namespace goetas\xml\wsdl;

use goetas\xml\XMLDomElement;
class BindingOperation extends WsdlElement
{
    /**
     * @var Operation
     */
    protected $operation;
    /**
     * @var \goetas\xml\wsdl\BindingMessage
     */
    protected $input;
    /**
     * @var \goetas\xml\wsdl\BindingMessage
     */
    protected $output;
    /**
     * @var \goetas\xml\wsdl\BindingMessage[]
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
     * @return \goetas\xml\wsdl\Binding
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
     * @return \goetas\xml\wsdl\Operation
     */
    public function getOperation()
    {
        return $this->operation;
    }
    /**
     * @return \goetas\xml\wsdl\BindingMessage
     */
    public function getInput()
    {
        return $this->input;
    }
    /**
     * @return \goetas\xml\wsdl\BindingMessage
     */
    public function getOutput()
    {
        return $this->output;
    }
    /**
     * @return \goetas\xml\wsdl\BindingMessage[]
     */
    public function getFaults()
    {
        return $this->output;
    }
}
