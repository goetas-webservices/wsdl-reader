<?php
namespace PhpWebservices\XML\WSDLReader\Tests;

use PhpWebservices\XML\WSDLReader\DefinitionsReader;
use PhpWebservices\XML\WSDLReader\Wsdl\Definitions;
use Jmikola\WildcardEventDispatcher\WildcardEventDispatcher;
use Symfony\Component\EventDispatcher\Event;

class EventsTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var \PhpWebservices\XML\WSDLReader\DefinitionsReader
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
        $expected[] = ['definitions_start',         'PhpWebservices\XML\WSDLReader\Events\DefinitionsEvent'];
        $expected[] = ['message',                   'PhpWebservices\XML\WSDLReader\Events\MessageEvent'];
        $expected[] = ['message.part',              'PhpWebservices\XML\WSDLReader\Events\Message\PartEvent'];
        $expected[] = ['message',                   'PhpWebservices\XML\WSDLReader\Events\MessageEvent'];
        $expected[] = ['message.part',              'PhpWebservices\XML\WSDLReader\Events\Message\PartEvent'];

        $expected[] = ['service',                   'PhpWebservices\XML\WSDLReader\Events\ServiceEvent'];
        $expected[] = ['service.port',              'PhpWebservices\XML\WSDLReader\Events\Service\PortEvent'];

        $expected[] = ['binding',                   'PhpWebservices\XML\WSDLReader\Events\BindingEvent'];

        $expected[] = ['binding.operation',         'PhpWebservices\XML\WSDLReader\Events\Binding\OperationEvent'];
        $expected[] = ['binding.operation.message', 'PhpWebservices\XML\WSDLReader\Events\Binding\MessageEvent'];
        $expected[] = ['binding.operation.message', 'PhpWebservices\XML\WSDLReader\Events\Binding\MessageEvent'];

        $expected[] = ['binding.operation',         'PhpWebservices\XML\WSDLReader\Events\Binding\OperationEvent'];
        $expected[] = ['binding.operation.message', 'PhpWebservices\XML\WSDLReader\Events\Binding\MessageEvent'];
        $expected[] = ['binding.operation.message', 'PhpWebservices\XML\WSDLReader\Events\Binding\MessageEvent'];

        $expected[] = ['binding.operation.fault',   'PhpWebservices\XML\WSDLReader\Events\Binding\FaultEvent'];
        $expected[] = ['binding.operation.fault',   'PhpWebservices\XML\WSDLReader\Events\Binding\FaultEvent'];

        $expected[] = ['portType',                  'PhpWebservices\XML\WSDLReader\Events\PortTypeEvent'];
        $expected[] = ['portType.operation',        'PhpWebservices\XML\WSDLReader\Events\PortType\OperationEvent'];
        $expected[] = ['portType.operation.param',  'PhpWebservices\XML\WSDLReader\Events\PortType\ParamEvent'];
        $expected[] = ['portType.operation.param',  'PhpWebservices\XML\WSDLReader\Events\PortType\ParamEvent'];

        $expected[] = ['portType.operation',        'PhpWebservices\XML\WSDLReader\Events\PortType\OperationEvent'];
        $expected[] = ['portType.operation.param',  'PhpWebservices\XML\WSDLReader\Events\PortType\ParamEvent'];
        $expected[] = ['portType.operation.param',  'PhpWebservices\XML\WSDLReader\Events\PortType\ParamEvent'];
        $expected[] = ['portType.operation.fault',  'PhpWebservices\XML\WSDLReader\Events\PortType\FaultEvent'];

        $expected[] = ['definitions_end', 'PhpWebservices\XML\WSDLReader\Events\DefinitionsEvent'];

        $this->assertCount(count($expected), $events);

        foreach ($expected as $index => $expectedData) {
            $event = $events[$index];

            $this->assertInstanceOf('Symfony\Component\EventDispatcher\Event', $event);
            $this->assertInstanceOf('PhpWebservices\XML\WSDLReader\Events\WsdlEvent', $event);
            $this->assertInstanceOf($expectedData[1], $event);
            $this->assertEquals($expectedData[0], $event->getName());
        }
    }

}