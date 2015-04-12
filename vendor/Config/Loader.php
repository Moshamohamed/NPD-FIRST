<?php
namespace Config;
use FileSystem\Finder;
class Loader{

   /**
   * the instance of Finder
   *
   * @var FileSystem/Finder
   */
   private $finder;

   /**
   * Create a new Config Repository
   *
   * @param FileSystem\Finder
   * @return void
   */
   public function __construct(Finder $finder)
   {
     $this->finder = $finder;
   }

   /**
   * load configuration data for the given key
   *
   * @param string $key
   * @return mixed
   */
   protected function load($key)
   {
     return $this->finder->get($key . '.php' , 'config');
   }
}