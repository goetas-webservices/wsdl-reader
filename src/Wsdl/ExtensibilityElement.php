<?php
namespace Goetas\XML\WSDLReader\Wsdl;

/**
 * XSD Type: tExtensibilityElement
 */
abstract class ExtensibilityElement
{

    /**
     * @var boolean
     */
    protected $required;
    
    
    /**
     * @return boolean
     */
    public function getRequired()
    {
        return $this->required;
    }
    /**
     * @param $required boolean
     * @return \Goetas\XML\WSDLReader\Wsdl\ExtensibilityElement
     */
    public function setRequired($required)
    {
        $this->required = $required;
        return $this;
    }
    
}
