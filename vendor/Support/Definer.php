<?php

namespace Support;
class Definer{
   public function setDefaultConstants()
   {
      define('http' , 'http' , true);

      //define('HTTP_SERVER' , HTTP.'://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/' . CURRENT_PATH);
      define('HTTP_PUBLIC' , HTTP.'://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/' . 'public' . '/');
      define('HTTP_UPLOADS' ,HTTP_PUBLIC.'uploads/');
      define('HTTP_FLAG',HTTP_PUBLIC.'uploads/images/flags/');// www.sitename.com/public/
      define('STORAGE_DIR' , ROOT .'storage' . DS);
      //define('LANGUAGE_DIR'   , ROOT . CURRENT_ROOT  . DS . 'language' . DS);
      define('PUBLIC_DIR'     , ROOT . 'public'      . DS);
      define('UPLOADS_DIR'    , ROOT . 'public'      . DS . 'uploads' . DS);
      define('IMAGES_DIR'     , UPLOADS_DIR . 'images' . DS);
      define('FILES_DIR'      , UPLOADS_DIR . 'files'  . DS);
      define('LOG_DIR'        , PUBLIC_DIR . 'log'   . DS);
      define('BACKUP_DIR'     , PUBLIC_DIR . 'backup'. DS);

      define('CACHE_DIR'      , STORAGE_DIR . 'cache' . DS);
   }
   public function set($key , $value , $sensitive = false)
   {
      if(!$this->isDefined($key))
      {
         define($key , $value , $sensitive);
      }
   }
   public function isDefined($key)
   {
      return defined($key);
   }
}