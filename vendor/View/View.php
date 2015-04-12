<?php

namespace View;

class View{
   /**
   * set the data that we got from the required template
   *
   * @var mixed
   */
   private $data;
  /**
  * Initialize the constructor of the view class
  *
  * @param string $template
  * @param array $output
  * @return mixed
  *
  */
  public function __construct($template , array $data = array() )
  {
     ob_start();

     extract($data);

     require $template;

     $this->data = ob_get_contents();

     ob_end_clean();
  }
  /**
  * get the data from the view
  *
  * @return mixed
  */
  private function sendData()
  {
     return $this->data;
  }
  /**
  * convert the class to a string and send it
  *
  * @return mixed
  */
  public function __toString()
  {
     return $this->sendData();
  }
}