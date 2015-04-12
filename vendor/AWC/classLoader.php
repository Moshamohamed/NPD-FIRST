<?php
namespace AWC;
class ClassLoader{
   /**
   * the alias container
   *
   * @var array
   */
   private $aliases = array();
   /**
   * initialize the constructor of the class
   *
   * @return void
   */
   public function __construct()
   {
      $this->loadHelper();

      $this->loadCLasses();

      $this->loadALiases();
   }
   /**
   * Load all classes that required by the framework
   *
   *@return void
   */
   private function loadCLasses()
   {
      spl_autoload_register(array($this , 'loadClass') , true , true);
   }
   /**
   * using this method for the spl_autoload_register function to load classes
   *
   * @param string $class
   * @return void
   */
   private function loadCLass($fullCLass)
   {
      // now we will check if the class has a namespace
      if(strpos($fullCLass , '\\') !== false)
      {
         // separate the namespace from the class name
         $fullCLass = explode('\\' , $fullCLass);

         // set the classname as it will be the last element in the array
         $class = array_pop($fullCLass);

         // now we will set the path of that class by looping to that array

         $folder = '';

         foreach($fullCLass AS $path)
         {
            $folder .= $path . DS;
         }

         // if the class exists just require it
         if(file_exists($file = VENDOR . $folder . $class . '.php'))
         {
            require $file;
         }
      }
   }
   /**
   * load classes and facade aliases
   *
   * @return void
   */
   private function loadAliases()
   {
      $classes = $this->getAliases();

      $facades = $this->getFacades();

      $this->setAliases($classes);

      $this->setAliases($facades);

      spl_autoload_register(array($this , 'loadAlias') , true , true);
   }
   /**
   * use the callback function for SPL Autoload for class alias
   *
   * @param string $class
   * @return string
   */
   private function loadAlias($alias)
   {
      if(isset($this->aliases[$alias]))
        return class_alias($this->aliases[$alias] , $alias);
   }
   /**
   * return the facades and its aliases
   *
   * @return array
   */
   private function getFacades()
   {
      return array(
         'App'      => 'Facades\\App',
         'Session'  => 'Facades\\Session',
         'View'     => 'Facades\\View',
         'Response' => 'Facades\\Response',
         'View'     => 'Facades\\View',
         'Define'   => 'Facades\\Define',
      );
   }
   /**
   * get the aliases for classes
   *
   * @return array
   */
   public function getAliases()
   {
      return array(
        'app'         => 'AWC\\Application',
        'config'      => 'Config\\Repository',
        'route'       => 'Routing\\Route',
        'session'     => 'Session\\SessionHandler',
        'request'     => 'Http\\Request',
        'response'    => 'Http\\Response',
        'view'        => 'View\\ViewFactory',
        'compressor'  => 'Support\\Compressor',
        'define'      => 'Support\\Definer',
        'finder'      => 'FileSystem\\Finder',
        'file'        => 'FileSystem\\FileManger',
      );
   }
   /**
   * set all aliases and classes in the aliases container
   *
   * @param array @aliases
   * @return void
   */
   private function setAliases(array $aliases)
   {
       if($this->aliases)
       {
          $this->aliases = array_merge($this->aliases,$aliases);
       }
       else
       {
          $this->aliases = $aliases;
       }
   }
   /**
   * load helper files
   *
   * @return void
   */
   private function loadHelper()
   {
     foreach(glob(VENDOR . 'Helpers' . DS . '*.php') AS $helper)
     {
       require $helper;
     }
   }
}