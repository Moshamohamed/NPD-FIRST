<?php
namespace View;
use Routing\Route;

class ViewFactory implements ViewInterFace{
   /**
   * the output of the template
   *
   * @var mixed
   */
   private $data;
  /**
  * the default extensions of the template that might be used by the developer
  *
  * @var array
  */
  private $extensions = array('php' , 'tpl');
  /**
  * instance of Route
  *
  * @var Routing\Route
  */
  private $route;
  /**
  * initialize the construct
  *
  * @return void
  */
  public function __construct(Route $route)
  {
    $this->route = $route;
  }
  /**
  * get the content of the view
  *
  * @param string $view
  * @param array $data
  */
  public function build($view , $data)
  {
    $path = $this->find($view);

    $this->data = new View($path , $data);
  }
  /**
  * get the data of the view
  *
  * @return mixed
  */
  public function getData()
  {
     return $this->data;
  }
  /**
  * find the path of the given template
  *
  * @param string view
  */
  public function find($view)
  {
    $script = $this->route->getCurrentScript();

    $path = ROOT . 'scripts' .DS . $script . DS . 'view' . DS . $view;

    foreach($this->extensions AS $ext)
    {
       if(file_exists($path = $path . '.' . $ext))
       {
          return $path;
       }
    }
    if(!file_exists($path))
    {
       die($path . ' is not found ');
    }
  }

}