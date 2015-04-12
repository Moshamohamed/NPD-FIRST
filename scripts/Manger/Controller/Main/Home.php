<?php
namespace Manger\Main;
use Routing\Controller;
class Home Extends Controller{
  public function index()
  {
     $data['home'] = 'hello admin home';

     view('Main/Home' , $data);
  }
  public function save($id , $data , $d)
  {
    echo $id. "<br>" . $data;
    echo "<br>" . $d;
  }
}