<?php

namespace Config;

interface RepositoryInterFace{
  public function get($key);
  public function set($key , $value);
  public function push($key , $value);
  public function prepend($key , $value);
  public function has($key);
}