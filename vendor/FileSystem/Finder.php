<?php
namespace FileSystem;

class Finder{
  /**
  * get the data from the given filename in the specified path
  * as this function is used to get files that expect to return data
  *
  * @param string $filename
  * @param string $path
  * @return mixed
  */
  public function get($filename , $path)
  {
    $path = ROOT  . $path . DS;

    if($this->exists($file = $path . $filename))
    {
      return require $file;
    }
    else
    {
      return false;
    }
  }
  /**
  * check if the given file exists
  *
  * @param string $file
  * @return bool true|false
  */
  public function exists($file)
  {
    return file_exists($file);
  }
}