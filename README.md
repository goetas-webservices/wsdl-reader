[![Build Status](https://travis-ci.org/goetas/wsdl-reader.svg?branch=master)](https://travis-ci.org/goetas/wsdl-reader)
[![Code Coverage](https://scrutinizer-ci.com/g/goetas/wsdl-reader/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/goetas/wsdl-reader/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/goetas/wsdl-reader/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/goetas/wsdl-reader/?branch=master)


PHP XSD Reader
==============

Read any [WSDL 1.1](http://en.wikipedia.org/wiki/Web_Services_Description_Language) (XSD) programmatically with PHP.


Installation
------------

There are two recommended ways to install the `wsdl-reader` via [Composer](https://getcomposer.org/):

* using the ``composer require`` command:

```bash
composer require 'php-webservices/wsdl-reader'
```

* adding the dependency to your ``composer.json`` file:

```js
"require": {
    ..
    "php-webservices/wsdl-reader" : "~0.1",
    ..
}
```
Getting started
---------------

```php
use PhpWebservices\XML\WSDLReader\DefinitionsReader;

$reader = new DefinitionsReader();
$definitions = $reader->readFile("http://www.example.com/exaple.wsdl");

// $definitions is instance of PhpWebservices\XML\WSDLReader\Wsdl\Definitions;
// Now you can navigate the entire WSDL structure

foreach ($definitions->getServices() as $service){

}
foreach ($definitions->getProtTypes() as $portType){

}
foreach ($definitions->getBindings() as $binding){

}
foreach ($definitions->getMessages() as $message){

}

```

Note
----

I'm sorry for the *terrible* english fluency used inside the documentation, I'm trying to improve it. 
Pull Requests are welcome.
