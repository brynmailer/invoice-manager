<?php

declare(strict_types=1);

namespace Api\Entity;

abstract class Entity implements \JsonSerializable {
  public function __construct($args) {
    foreach ($args as $key => $value) {
      if (\property_exists($this, $key)) {
        $rp = new \ReflectionProperty(\get_class($this), $key);
        $className = $rp->getType()->getName();
        if (class_exists($className)) {
          $this->{$key} = new $className($value);
        } else {
          $this->{$key} = $value;
        }
      }
    }
  }

  public function jsonSerialize() {
    $serialized = [];
    foreach ($this as $key => $value) {
      $serialized[$key] = $value;
    }
    return $serialized;
  }
}
