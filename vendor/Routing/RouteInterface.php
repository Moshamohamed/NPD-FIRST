<?php

namespace Routing;

interface RouteInterface{
  public function initializeRouter();
  public function build();
}