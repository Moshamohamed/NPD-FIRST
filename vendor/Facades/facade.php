<?php

namespace Facades;
use AWC\Application;

abstract class facade{
   /**
   * set the Application instance
   *
   * @var AWC\Application
   */
   private static $app;
   /**
   * set the instances of the classes in the instance container
   * @var array
   */
   private static $instances = array();
   /**
   * get the instance name from its facade class
   *
   * @return void
   */
   public static function call(){}

   /**
   * Set the Application instance to the facade class
   *
   * @param AWC\Application
   * @return void
   */
   public static function setApplicationFacade(Application $app)
   {
      static::$app = $app;
   }
   /*
   * get the instance of the required facade
   *
   * @return mixed
   */
   private static function getFacadeInstance()
   {
      return static::getInstance(static::call());
   }

   /*
   * return the object of the required class
   *
   * @param string $name
   * @return mixed
   */
   private static function getInstance($name)
   {
      if(isset(self::$instances[$name]))
        return self::$instances[$name];

      return self::$instances[$name] = self::$app[$name];
   }

   /*
   * get calls from static methods
   *
   * @param string $method
   * @param array $args
   * @return mixed
   */

   public static function __callStatic($method , $args)
   {
      $instance = self::getFacadeInstance();

      switch(count($args))
      {
         case 0 :
            return $instance->$method();
         case 1 :
            return $instance->$method($args[0]);
         case 2 :
            return $instance->$method($args[0],$args[1]);
         case 3 :
            return $instance->$method($args[0],$args[1],$args[2]);
         default :
          return call_user_func_array(array($instance,$method),$args);
      }
   }


}