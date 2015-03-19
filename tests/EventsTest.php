<?php
namespace GoetasWebservices\XML\WSDLReader\Tests;

use GoetasWebservices\XML\WSDLReader\DefinitionsReader;
use GoetasWebservices\XML\WSDLReader\Wsdl\Definitions;
use Jmikola\WildcardEventDispatcher\WildcardEventDispatcher;
use Symfony\Component\EventDispatcher\Event;

class EventsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \GoetasWebservices\XML\WSDLReader\DefinitionsReader
     */
    protected $reader;

    /**
     *
     * @var \Jmikola\WildcardEventDispatcher\WildcardEventDispatcher
     */
    protected $dispatcher;

    public function setUp()
    {
        $this->dispatcher = new WildcardEventDispatcher();
        $this->reader = new DefinitionsReader(null, $this->dispatcher);
    }

    public function testReadFile()
    {
        $events = array();
        $this->dispatcher->addListener("#", function(Event $e) use (&$events){
            $events[] = $e;
        });
        $this->reader->readFile(__DIR__.'/resources/base-wsdl-events.wsdl');

        $expected = [];
        $expected[] = ['definitions_start',         'GoetasWebservices\XML\WSDLReader\Events\DefinitionsEvent'];
        $expected[] = ['message',                   'GoetasWebservices\XML\WSDLReader\Events\MessageEvent'];
        $expected[] = ['message.part',              'GoetasWebservices\XML\WSDLReader\Events\Message\PartEvent'];
        $expected[] = ['message',                   'GoetasWebservices\XML\WSDLReader\Events\MessageEvent'];
        $expected[] = ['message.part',              'GoetasWebservices\XML\WSDLReader\Events\Message\PartEvent'];

        $expected[] = ['service',                   'GoetasWebservices\XML\WSDLReader\Events\ServiceEvent'];
        $expected[] = ['service.port',              'GoetasWebservices\XML\WSDLReader\Events\Service\PortEvent'];

        $expected[] = ['binding',                   'GoetasWebservices\XML\WSDLReader\Events\BindingEvent'];

        $expected[] = ['binding.operation',         'GoetasWebservices\XML\WSDLReader\Events\Binding\OperationEvent'];
        $expected[] = ['binding.operation.message', 'GoetasWebservices\XML\WSDLReader\Events\Binding\MessageEvent'];
        $expected[] = ['binding.operation.message', 'GoetasWebservices\XML\WSDLReader\Events\Binding\MessageEvent'];

        $expected[] = ['binding.operation',         'GoetasWebservices\XML\WSDLReader\Events\Binding\OperationEvent'];
        $expected[] = ['binding.operation.message', 'GoetasWebservices\XML\WSDLReader\Events\Binding\MessageEvent'];
        $expected[] = ['binding.operation.message', 'GoetasWebservices\XML\WSDLReader\Events\Binding\MessageEvent'];

        $expected[] = ['binding.operation.fault',   'GoetasWebservices\XML\WSDLReader\Events\Binding\FaultEvent'];
        $expected[] = ['binding.operation.fault',   'GoetasWebservices\XML\WSDLReader\Events\Binding\FaultEvent'];

        $expected[] = ['portType',                  'GoetasWebservices\XML\WSDLReader\Events\PortTypeEvent'];
        $expected[] = ['portType.operation',        'GoetasWebservices\XML\WSDLReader\Events\PortType\OperationEvent'];
        $expected[] = ['portType.operation.param',  'GoetasWebservices\XML\WSDLReader\Events\PortType\ParamEvent'];
        $expected[] = ['portType.operation.param',  'GoetasWebservices\XML\WSDLReader\Events\PortType\ParamEvent'];

        $expected[] = ['portType.operation',        'GoetasWebservices\XML\WSDLReader\Events\PortType\OperationEvent'];
        $expected[] = ['portType.operation.param',  'GoetasWebservices\XML\WSDLReader\Events\PortType\ParamEvent'];
        $expected[] = ['portType.operation.param',  'GoetasWebservices\XML\WSDLReader\Events\PortType\ParamEvent'];
        $expected[] = ['portType.operation.fault',  'GoetasWebservices\XML\WSDLReader\Events\PortType\FaultEvent'];

        $expected[] = ['definitions_end', 'GoetasWebservices\XML\WSDLReader\Events\DefinitionsEvent'];

        $this->assertCount(count($expected), $events);

        foreach ($expected as $index => $expectedData) {
            $event = $events[$index];

            $this->assertInstanceOf('Symfony\Component\EventDispatcher\Event', $event);
            $this->assertInstanceOf('GoetasWebservices\XML\WSDLReader\Events\WsdlEvent', $event);
            $this->assertInstanceOf($expectedData[1], $event);
            $this->assertEquals($expectedData[0], $event->getName());
        }
    }

}