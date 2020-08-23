<?php 

namespace Api;

class Dispatcher {
  private $definitions = [];
  private $instances = [];
  private Container $container;

  public function __construct($container) {
    $this->container = $container;

    foreach ($container->config['routeMap'] as $className) {
      $this->definitions[] = $className;
    }
  }

  public function dispatch($uri, $method) {
    $map = $this->container->config['routeMap'];

    $route = "$method $uri";
    $match = $service = isset($map[$route]) ? $map[$route] : null;
    if (!$match) throw new Exception\NoMatchingRoute();

    return $this->getInstance($service)->execute();
  }

  public function getInstance($id) {
    if (!in_array($id, $this->definitions)) {
      throw new Exception\DependencyNotFound();
    }

    if (!array_key_exists($id, $this->instances)) {
      $this->instances[$id] = new Route\Ping($this->container);
    }

    return $this->instances[$id];
  }
}
