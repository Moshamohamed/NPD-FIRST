<?php
namespace View;
interface viewInterface{
  /**
  * get the content of the view
  *
  * @param string $view
  * @param array $data
  */
  public function build($view , $data);
  /**
  * find the path of the given template
  *
  * @param string view
  */
  public function find($view);

}