<?php

namespace AWC;
use ArrayAccess;
use Http\Response;
use Config\Repository as Config;
use View\ViewFactory as View;

class Application implements ArrayAccess{
   /**
   * set the class container for class instances
   * @var array
   */
   private $instances = array();
   /**
   * set class name and its alias in the alias container
   * @var array
   */
   private $aliases = array();
   /**
   * initialize the constructor
   *
   * @return void
   */
   public function __construct($aliases)
   {
     $this->setAliases($aliases);
     $this->bootstrap();
   }
   /**
   * call and return the class object
   *
   * @param string $class
   * @ return mixed
   */
   public function get($class)
   {
     $class = strtolower($class);

      if(!isset($this->instances[$class]))
         $this->instance($class);

      return $this->instances[$class];
   }
   /**
   * Fire the application
   *
   * @return mixed
   */
   public function fire()
   {
      $this->session->start();

      $this->instance('response' , new Response($this->compressor));

      $this->instance('view' , new View($this->route));

      $this->route->build();

      $this->response->setContent($this->view->getData());

      $this->response->send();
   }
   /**
   * set the class instance to instances contaienr
   *
   * @param string $class
   * @return void
   */
   private function instance($class , $instance = false)
   {
     $class = strtolower($class);

      if(!isset($this->instances[$class]))
      {
         if(!$instance)
         {
            $classAlias =  $this->getClassAlias($class);

            $this->instances[$class] = new $classAlias($this);
         }
         else
         {
            $this->instances[$class] = $instance;
         }
      }
   }
   /*
   * Set the class and its alias in the alias container
   *
   * @param array $aliases
   * @return void
   */
   private function setAliases(array $aliases)
   {
      $this->aliases = $aliases;
   }
   /**
   * set the default not found page if it is not found in the script
   *
   * @return void
   */
   public function notFoundPage()
   {
      require VENDOR . 'AWC' . DS . 'notFound.php';
      die();
   }
   /**
   * bootstrap the framework with main configurations
   *
   * @return void
   */
   private function bootstrap()
   {
      $this->registerApplication();

      $this->instance('config' , new Config($this->finder));

      $this->route->initializeRouter();
   }
   /**
   * set the Application instance itself in the instance container so we can use it
   *
   * @ return void
   */
   private function registerApplication()
   {
      $this->instances['app']  = $this;
   }
   /**
   * get the class alias
   *
   * @param string $class
   * @return mixed
   */
   private function getClassAlias($class)
   {
      if(isset($this->aliases[$class])) return $this->aliases[$class];
   }
   /**
   * set object to instance container
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
   public function __set($key , $value)
   {
      $this->instance($key , $value);
   }
   /**
   * get the instance from instance container
   *
   * @param string $key
   * @return mixed
   */
   public function __get($key)
   {
      return $this->get($key);
   }
   /**
   * set the value of the given offset
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
   public function offsetSet($key , $value)
   {
      $this->instance($key , $value);
   }
   /**
   * get the value of the given offset
   *
   * @param string $key
   * @return mixed
   */
   public function offsetGet($key)
   {
      return $this->get($key);
   }
   /**
   * Unset the given offset
   *
   * @param string $Key
   * @return void
   */
   public function offsetUnset($key)
   {
      if(isset($this->instances[$key]))
          unset($this->instances[$key]);
   }
   /**
   * check if the given offset is set
   *
   * @param string $key
   * @return bool true|false
   */
   public function offsetExists($key)
   {
      return isset($this->instances[$key]);
   }
}