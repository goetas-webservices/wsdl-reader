<?php
namespace GoetasWebservices\XML\WSDLReader\Wsdl;

/**
 * This type is extended by  component types to allow them to be documented
 *
 * XSD Type: tDocumented
 */
class Documented
{

    /**
     * @var string
     */
    protected $documentation;


    /**
     * @return string
     */
    public function getDocumentation()
    {
        return $this->documentation;
    }

    /**
     * @param $documentation string
     * @return \GoetasWebservices\XML\WSDLReader\Wsdl\Documented
     */
    public function setDocumentation($documentation)
    {
        $this->documentation = $documentation;
        return $this;
    }

    protected $definition;

    public function __construct(Definitions $defintion)
    {
        $this->definition = $defintion;
    }

    /**
     *
     * @return Definitions
     */
    public function getDefinition()
    {
        return $this->definition;
    }
}
