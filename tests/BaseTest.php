<?php
namespace GoetasWebservices\XML\WSDLReader\Tests;

use GoetasWebservices\XML\WSDLReader\DefinitionsReader;
use GoetasWebservices\XML\WSDLReader\Wsdl\Definitions;
use GoetasWebservices\XML\XSDReader\Schema\Element\ElementDef;
use GoetasWebservices\XML\XSDReader\Schema\Type\ComplexType;
use PHPUnit\Framework\TestCase;

class BaseTest extends TestCase
{

    /**
     *
     * @var \GoetasWebservices\XML\WSDLReader\DefinitionsReader
     */
    protected $reader;

    public function setUp(): void
    {
        $this->reader = new DefinitionsReader();
    }

    public function testReadFile()
    {
        $definitions = $this->reader->readFile(__DIR__ . '/resources/base-wsdl.wsdl');

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Definitions', $definitions);
        $this->makeAssertionsLoad($definitions);
    }

    public function testReadCrossReferenceDefinitions()
    {
        $definitions = $this->reader->readFile(__DIR__ . '/resources/multi-schema-cross-reference.wsdl');

        $details = $definitions->getSchema()->findType("outerType", "http://tempuri.org/1");
        $this->assertInstanceOf(ComplexType::class, $details);

        $details = $definitions->getSchema()->findElement("outerEl", "http://tempuri.org/1");
        $this->assertInstanceOf(ElementDef::class, $details);
    }

    public function testReadString()
    {
        $definitions = $this->reader->readString(file_get_contents(__DIR__ . '/resources/base-wsdl.wsdl'));
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Definitions', $definitions);
        $this->makeAssertionsLoad($definitions);
    }

    public function testReadNode()
    {
        $dom = new \DOMDocument();
        $dom->load(__DIR__ . '/resources/base-wsdl.wsdl');
        $definitions = $this->reader->readNode($dom->documentElement);

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Definitions', $definitions);
        $this->makeAssertionsLoad($definitions);
    }

    public function testImport()
    {
        $definitions = $this->reader->readFile(__DIR__ . '/resources/base-wsdl-import.wsdl');

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Definitions', $definitions);
        $this->assertEquals("bar", $definitions->getName());
        // import test
        $imports = $definitions->getImports();
        $this->assertCount(1, $imports);
        $this->makeAssertionsLoad(reset($imports));

        $this->assertNotNull($definitions->findBinding('StockQuoteSoap', 'http://www.example.com'));
        $this->assertNotNull($definitions->findMessage('GetQuoteSoapIn', 'http://www.example.com'));
        $this->assertNotNull($definitions->findPortType('StockQuoteSoap', 'http://www.example.com'));
        $this->assertNotNull($definitions->findService('StockQuote', 'http://www.example.com'));
    }

    /**
     * @expectedException \Exception
     */
    public function testTypeNotFound()
    {
        $definitions = $this->reader->readFile(__DIR__ . '/resources/base-wsdl-import.wsdl');
        $this->assertNotNull($definitions->findBinding('StockQuoteSoap2', 'http://www.example.com'));
    }

    protected function makeAssertionsLoad(Definitions $definitions)
    {

        $this->assertEquals("foo", $definitions->getName());

        $this->assertCount(2, $definitions->getMessages());
        $this->assertCount(1, $definitions->getBindings());
        $this->assertCount(1, $definitions->getPortTypes());
        $this->assertCount(1, $definitions->getServices());

        $this->assertEquals('http://www.example.com', $definitions->getTargetNamespace());

        // messages
        $messages = $definitions->getMessages();
        $this->assertArrayHasKey('GetQuoteSoapIn', $messages);
        $this->assertArrayHasKey('GetQuoteSoapOut', $messages);
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Message', $messages['GetQuoteSoapIn']);
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Message', $messages['GetQuoteSoapOut']);
        $this->assertSame($definitions->getMessage('GetQuoteSoapIn'), $messages['GetQuoteSoapIn']);
        $this->assertSame($definitions->getMessage('GetQuoteSoapOut'), $messages['GetQuoteSoapOut']);

        // messsage parts
        $messageParts = $definitions->getMessage('GetQuoteSoapIn')->getParts();
        $this->assertArrayHasKey('parameters', $messageParts);
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part', $messageParts['parameters']);
        $this->assertInstanceOf('GoetasWebservices\XML\XSDReader\Schema\Element\ElementDef', $messageParts['parameters']->getElement());
        $this->assertNull($messageParts['parameters']->getType());


        $messageParts = $definitions->getMessage('GetQuoteSoapOut')->getParts();
        $this->assertArrayHasKey('parameters', $messageParts);
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Message\Part', $messageParts['parameters']);
        $this->assertInstanceOf('GoetasWebservices\XML\XSDReader\Schema\Type\ComplexType', $messageParts['parameters']->getType());
        $this->assertNull($messageParts['parameters']->getElement());

        //port types
        $portTypes = $definitions->getPortTypes();
        $this->assertArrayHasKey('StockQuoteSoap', $portTypes);
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\PortType', $portTypes['StockQuoteSoap']);
        $this->assertSame($definitions->getPortType('StockQuoteSoap'), $portTypes['StockQuoteSoap']);

        // port type opertations
        $portType = $definitions->getPortType('StockQuoteSoap');
        $operations = $portType->getOperations();
        $this->assertArrayHasKey('GetQuote', $operations);
        $this->assertArrayHasKey('GetQuoteWithFault', $operations);

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Operation', $operations['GetQuote']);
        $this->assertSame($portType->getOperation('GetQuote'), $operations['GetQuote']);

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param', $operations['GetQuote']->getInput());
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param', $operations['GetQuote']->getOutput());
        $this->assertEmpty($operations['GetQuote']->getFaults());

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Operation', $operations['GetQuoteWithFault']);
        $this->assertSame($portType->getOperation('GetQuoteWithFault'), $operations['GetQuoteWithFault']);

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param', $operations['GetQuoteWithFault']->getInput());
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Param', $operations['GetQuoteWithFault']->getOutput());
        $this->assertCount(1, $operations['GetQuoteWithFault']->getFaults());
        $this->assertContainsOnlyInstancesOf('GoetasWebservices\XML\WSDLReader\Wsdl\PortType\Fault', $operations['GetQuoteWithFault']->getFaults());

        $this->assertArrayHasKey('foo', $operations['GetQuoteWithFault']->getFaults());


        //bindings
        $bindings = $definitions->getBindings();
        $this->assertArrayHasKey('StockQuoteSoap', $bindings);
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Binding', $bindings['StockQuoteSoap']);
        $this->assertSame($definitions->getBinding('StockQuoteSoap'), $bindings['StockQuoteSoap']);

        //binding operation
        $binding = $definitions->getBinding('StockQuoteSoap');
        $this->assertSame($binding->getType(), $portTypes['StockQuoteSoap']);

        $operations = $binding->getOperations();
        $this->assertArrayHasKey('GetQuote', $operations);
        $this->assertArrayHasKey('GetQuoteWithFault', $operations);

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation', $operations['GetQuote']);
        $this->assertSame($binding->getOperation('GetQuote'), $operations['GetQuote']);

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage', $operations['GetQuote']->getInput());
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage', $operations['GetQuote']->getOutput());
        $this->assertEmpty($operations['GetQuote']->getFaults());


        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Binding\Operation', $operations['GetQuoteWithFault']);
        $this->assertSame($binding->getOperation('GetQuoteWithFault'), $operations['GetQuoteWithFault']);

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage', $operations['GetQuoteWithFault']->getInput());
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationMessage', $operations['GetQuoteWithFault']->getOutput());
        $this->assertCount(2, $operations['GetQuoteWithFault']->getFaults());
        $this->assertContainsOnlyInstancesOf('GoetasWebservices\XML\WSDLReader\Wsdl\Binding\OperationFault', $operations['GetQuoteWithFault']->getFaults());

        $this->assertArrayHasKey('foo', $operations['GetQuoteWithFault']->getFaults());
        $this->assertArrayHasKey('bar', $operations['GetQuoteWithFault']->getFaults());

        // services
        $services = $definitions->getServices();

        $this->assertArrayHasKey('StockQuote', $services);

        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Service', $services['StockQuote']);
        $this->assertSame($definitions->getService('StockQuote'), $services['StockQuote']);
        $service = $definitions->getService('StockQuote');

        $this->assertEquals("Foo", $service->getDocumentation());

        $ports = $service->getPorts();
        $this->assertArrayHasKey('StockQuoteSoap', $ports);
        $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Wsdl\Service\Port', $ports['StockQuoteSoap']);
        $this->assertSame($service->getPort('StockQuoteSoap'), $ports['StockQuoteSoap']);
        // port bindig
        $this->assertSame($service->getPort('StockQuoteSoap')->getBinding(), $bindings['StockQuoteSoap']);


        $this->assertSame($bindings['StockQuoteSoap'], $definitions->findBinding('StockQuoteSoap'));
        $this->assertSame($messages['GetQuoteSoapIn'], $definitions->findMessage('GetQuoteSoapIn'));
        $this->assertSame($portTypes['StockQuoteSoap'], $definitions->findPortType('StockQuoteSoap'));
        $this->assertSame($services['StockQuote'], $definitions->findService('StockQuote'));

        $this->assertSame($bindings['StockQuoteSoap'], $definitions->findBinding('StockQuoteSoap', 'http://www.example.com'));
        $this->assertSame($messages['GetQuoteSoapIn'], $definitions->findMessage('GetQuoteSoapIn', 'http://www.example.com'));
        $this->assertSame($portTypes['StockQuoteSoap'], $definitions->findPortType('StockQuoteSoap', 'http://www.example.com'));
        $this->assertSame($services['StockQuote'], $definitions->findService('StockQuote', 'http://www.example.com'));


    }
}
