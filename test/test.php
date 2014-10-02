<?php

require __DIR__.'/../vendor/autoload.php';

use Goetas\XML\WSDLReader\WsdlReader;
$reader = new WsdlReader();

$reader->readFile(__DIR__."/test.wsdl");