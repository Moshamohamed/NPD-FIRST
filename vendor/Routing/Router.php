<?php
namespace Routing;
use Config\ConfigRepository as config;
use Http\Request;
class Router{
  /**
  * routes of the current script
  *
  * @var array
  */
  private $routes = array();

  /**
  * not found route
  *
  * @var mixed
  */
  private $notFound;

  /**
  * set the main routes of the current scripts
  *
  * @param array $rotues
  * @return void
  */
  public function __construct(array $routes)
  {
    if(isset($routes['routes']))
    {
      $this->routes = $routes['routes'];
    }

    if(isset($routes['not-found']))
    {
      $this->notFound = $routes['not-found'];
    }
  }
  /**
  * get the data of not found controller
  *
  * @return mixed
  */
  public function getNotFound()
  {
    return $this->notFound;
  }
  /**
  * return all paths for current script
  *
  * @return array
  */
  public function getScriptRoutes()
  {
    return $this->routes;
  }
}