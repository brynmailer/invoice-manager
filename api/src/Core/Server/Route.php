<?php declare(strict_types=1);

namespace InvMan\Core\Server;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

class Route {
  public string $path;
  private array $stack = [];

  public function __construct(
    string $path
  ) {
    $this->path = $path;
  }

  public function dispatch(
    ServerRequest $req,
    JsonResponse $res
  ): JsonResponse {
    $idx = 0;
    $stack = $this->stack;

    $next = function (
      $req,
      $res
    ) use (
      &$idx,
      $stack,
      &$next
    ) {
      $layer = $stack[$idx++];

      if (!$layer) {
        return $res;
      }
      
      $method = \strtolower($req->getServerParams()['REQUEST_METHOD']);

      if ($layer->method && $layer->method !== $method) {
        return $next($req, $res);
      }

      return $layer->handle_request($req, $res, $next);
    };
    
    return $next($req, $res);
  }

  public function get(
    array $handles = []
  ): Route {
    foreach ($handles as &$handle) {
      $layer = new Layer($this->path, $handle);
      $layer->method = 'get';
      $this->stack[] = $layer;
    }

    return $this;
  } 

  public function post(
    array $handles = []
  ): Route {
    foreach ($handles as &$handle) {
      $layer = new Layer($this->path, $handle);
      $layer->method = 'post';
      $this->stack[] = $layer;
    }

    return $this;
  } 

  public function put(
    array $handles = []
  ): Route {
    foreach ($handles as &$handle) {
      $layer = new Layer($this->path, $handle);
      $layer->method = 'put';
      $this->stack[] = $layer;
    }

    return $this;
  } 

  public function delete(
    array $handles = []
  ): Route {
    foreach ($handles as &$handle) {
      $layer = new Layer($this->path, $handle);
      $layer->method = 'delete';
      $this->stack[] = $layer;
    }

    return $this;
  } 
}
