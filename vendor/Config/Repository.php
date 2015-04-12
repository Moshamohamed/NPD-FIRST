<?php
namespace Config;
use ArrayAccess;
class Repository extends Loader implements RepositoryInterFace , ArrayAccess{
   /**
   * the items container
   * @var array
   */
   protected $items = array();

   /**
   * get the value of the given key from the config container
   *
   * @param string $key
   * @return mixed
   */
   public function get($key)
   {
     if(!$this->has($key))
     {
       $this->set($key);
     }
     return $this->items[$key];
   }

   /**
   * set a value to config container
   *
   * @param string $key
   * @param mixed $value
   * @return void
   */
   public function set($key , $value = null)
   {
     if(!$value)
     {
       if(strpos($key , '.') !== false)
       {
         $group = strstr($key ,'.' , true);

         $this->storeItems($group , $this->load($group));
       }
       else
       {
         $this->storeItems($key , $this->load($key));
       }
     }
     else
     {
       $this->items[$key] = $value;
     }
   }

   /**
   * store the given data to repository container
   *
   * @param string $key
   * @param mixed $data
   * @return void
   */
   private function storeItems($group , $data)
   {
     $this->items[$group] = $data;

     if(is_array($data))
     {
       foreach($data as $key => $value)
       {
         if(is_array($value))
         {
           $this->storeItems($group . '.' . $key , $value);
         }
         else
         {
           $this->items[$group . '.' . $key] = $this->items[$group][$key] = $value;
         }
       }
     }
   }

   /**
   * determine whether the given configuration key exists or not
   *
   * @param string $key
   * @return bool true|false
   */
   public function has($key)
   {
     return isset($this->items[$key]);
   }

   /**
   * push new element to the repository
   *
   * @param string $key
   * @prarm mixed $value
   * @return void
   */
   public function push($key , $value)
   {
     $items = $this->get($key);
     $items[] = $value;
     $this->set($key , $items);
   }

   /**
   * push new element to the repository
   *
   * @param string $key
   * @prarm mixed $value
   * @return void
   */
   public function prepend($key , $value)
   {
     $items = $this->get($key);
     array_unshift($items , $value);
     $this->set($key , $items);
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
      $this->set($key , $value);
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
     if($this->has($key))
        unset($this->items[$key]);
   }
   /**
   * check if the given offset is set
   *
   * @param string $key
   * @return bool true|false
   */
   public function offsetExists($key)
   {
      return $this->has($key);
   }
}