<?php

// define the vendor path
define('VENDOR' , ROOT  . 'vendor' . DS);

// require the classloader and initialize it
require_once VENDOR . 'AWC' . DS .'classLoader.php';
$classLoader = new AWC\classLoader();

/**
* initialize the Application class
* save the aliases to Application class
*/
$app = new AWC\Application($classLoader->getAliases());

// use the facade class
use Facades\Facade;

// save the Application instance to the facade
Facade::setApplicationFacade($app);

return $app;