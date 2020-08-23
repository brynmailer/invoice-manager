<?php

namespace Api\Exception;

class DependencyNotFound extends \Exception {
  protected $code = 503;
}
