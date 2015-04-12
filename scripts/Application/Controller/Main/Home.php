<?php

namespace Application\Main;
use Routing\Controller;

class Home Extends Controller{
  public function index($arg1 , $arg2)
  {
    echo $arg1."<br>";
    echo $arg2."<br>";
    $data['home'] = 'hello home';
     view('Main/Home' , $data);
  }
  public function load()
  {
  	echo 'Loaded :D';
  }
}