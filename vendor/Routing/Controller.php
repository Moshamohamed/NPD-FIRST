<?php
namespace Routing;
use AWC\Application;
abstract class Controller{
  /**
  * Application instance
  *
  * @var AWC\Application
  */
  private $app;
  /*
  *
  * initialize the constructor
  *
  * @return void
  */
  public function __construct(Application $app)
  {
    $this->app = $app;
  }
  /*
  *
  * set key and value to the class
  *
  * @param string $key
  * @param mixed $value
  * @return void
  */
  public function __set($key , $value)
  {
    $this->app->setInstance($key , $value);
  }
  /*
  *
  * get the instance of the given key
  *
  * @param string $key
  * @return mixed
  */
  public function __get($key)
  {
    return $this->app[$key];
  }
}