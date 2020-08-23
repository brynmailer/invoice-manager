<?php

namespace Api\Route;

abstract class Route {
  protected \Api\Container $container;

  public function __construct($container) {
    $this->container = $container;
  }
}
