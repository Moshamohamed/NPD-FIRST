<?php
/**
*
* function to var dump or print_r array
*
* @param array $array
* @param string $print_type
* @return void
*/
if(!function_exists('pre'))
{
   function pre($array , $print_type = 'print')
   {
      echo '<pre>';
      if($print_type == 'dump')
      {
         var_dump($array);
      }
      else
      {
         print_r($array);
      }
      echo '</pre>';
   }
}
/**
* a shorthand function to set the output of view class
*
* @param string $template
* @param array $output
* @param bool $compress
* @return mixed
*/
if(!function_exists('view'))
{
  function view($template , $data = array() , $compress = true)
  {
    Response::setHeader('Content-Type: text/html; charset=utf-8');

    Response::Compress($compress);

    View::build($template , $data);
  }
}