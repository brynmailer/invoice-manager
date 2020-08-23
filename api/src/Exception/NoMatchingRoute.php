<?php

namespace Api\Exception;

class NoMatchingRoute extends \Exception {
  protected $code = 404;
}
