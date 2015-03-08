<?php
namespace Goetas\XML\WSDLReader\Tests;

use Goetas\XML\WSDLReader\DefinitionsReader;
use Goetas\XML\WSDLReader\Wsdl\Definitions;
use Jmikola\WildcardEventDispatcher\WildcardEventDispatcher;
use Symfony\Component\EventDispatcher\Event;

class EventsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \Goetas\XML\WSDLReader\DefinitionsReader
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
        $expected[] = ['definitions_start',         'Goetas\XML\WSDLReader\Events\DefinitionsEvent'];
        $expected[] = ['message',                   'Goetas\XML\WSDLReader\Events\MessageEvent'];
        $expected[] = ['message.part',              'Goetas\XML\WSDLReader\Events\Message\PartEvent'];
        $expected[] = ['message',                   'Goetas\XML\WSDLReader\Events\MessageEvent'];
        $expected[] = ['message.part',              'Goetas\XML\WSDLReader\Events\Message\PartEvent'];

        $expected[] = ['service',                   'Goetas\XML\WSDLReader\Events\ServiceEvent'];
        $expected[] = ['service.port',              'Goetas\XML\WSDLReader\Events\Service\PortEvent'];

        $expected[] = ['binding',                   'Goetas\XML\WSDLReader\Events\BindingEvent'];

        $expected[] = ['binding.operation',         'Goetas\XML\WSDLReader\Events\Binding\OperationEvent'];
        $expected[] = ['binding.operation.message', 'Goetas\XML\WSDLReader\Events\Binding\MessageEvent'];
        $expected[] = ['binding.operation.message', 'Goetas\XML\WSDLReader\Events\Binding\MessageEvent'];

        $expected[] = ['binding.operation',         'Goetas\XML\WSDLReader\Events\Binding\OperationEvent'];
        $expected[] = ['binding.operation.message', 'Goetas\XML\WSDLReader\Events\Binding\MessageEvent'];
        $expected[] = ['binding.operation.message', 'Goetas\XML\WSDLReader\Events\Binding\MessageEvent'];

        $expected[] = ['binding.operation.fault',   'Goetas\XML\WSDLReader\Events\Binding\FaultEvent'];
        $expected[] = ['binding.operation.fault',   'Goetas\XML\WSDLReader\Events\Binding\FaultEvent'];

        $expected[] = ['portType',                  'Goetas\XML\WSDLReader\Events\PortTypeEvent'];
        $expected[] = ['portType.operation',        'Goetas\XML\WSDLReader\Events\PortType\OperationEvent'];
        $expected[] = ['portType.operation.param',  'Goetas\XML\WSDLReader\Events\PortType\ParamEvent'];
        $expected[] = ['portType.operation.param',  'Goetas\XML\WSDLReader\Events\PortType\ParamEvent'];

        $expected[] = ['portType.operation',        'Goetas\XML\WSDLReader\Events\PortType\OperationEvent'];
        $expected[] = ['portType.operation.param',  'Goetas\XML\WSDLReader\Events\PortType\ParamEvent'];
        $expected[] = ['portType.operation.param',  'Goetas\XML\WSDLReader\Events\PortType\ParamEvent'];
        $expected[] = ['portType.operation.fault',  'Goetas\XML\WSDLReader\Events\PortType\FaultEvent'];

        $expected[] = ['definitions_end', 'Goetas\XML\WSDLReader\Events\DefinitionsEvent'];

        $this->assertCount(count($expected), $events);

        foreach ($expected as $index => $expectedData) {
            $event = $events[$index];

            $this->assertInstanceOf('Symfony\Component\EventDispatcher\Event', $event);
            $this->assertInstanceOf('Goetas\XML\WSDLReader\Events\WsdlEvent', $event);
            $this->assertInstanceOf($expectedData[1], $event);
            $this->assertEquals($expectedData[0], $event->getName());
        }
    }

}