<?php
session_start();

// set directory separator in shorthand DS constant
define('DS' , DIRECTORY_SEPARATOR);

// set the path of the framework in ROOT constant
define('ROOT' , dirname(__FILE__) . DS);

// require the loader file
$awc = require_once ROOT.'vendor' . DS . 'loader.php';

Session::set('f','session');
Session::set('f2','session');
// Session::set('f3','session');

// print_r(Session::get('f'));
print_r(Session::flush());
print_r(Session::all());

die();

// fire the application
$awc->fire();
