<?php

namespace Api\Route;

class Ping extends Route {
  public function execute() {
    return 'hi';
  }
}
