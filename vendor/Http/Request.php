<?php
namespace Http;
class Request{
   /**
   * get the value from $_GET Request
   *
   * @param $key
   * @return mixed
   */
   public function get($key)
   {
      return isset($_GET[$key]) ? $_GET[$key] : false;
   }
   /**
   * get the value from $_SERVER
   *
   * @param $key
   * @return mixed
   */
   public function server($key)
   {
     return isset($_SERVER[$key]) ? $_SERVER[$key] : false;
   }
}