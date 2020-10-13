<?php declare(strict_types=1);

namespace Lib\Api;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;

class Router {
  private array $stack = [];

  public function route(
    string $path
  ): Route {
    $route = new Route($path);
    $layer = new Layer($path, [$route, 'dispatch']);
    $layer->route = $route;
    $this->stack[] = $layer;
    return $route;
  }

  public function handle(): JsonResponse {
    $req = ServerRequestFactory::fromGlobals();
    $res = (new JsonResponse(null))
      ->withStatus(404);

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
      $layer = isset($stack[$idx]) ? $stack[$idx] : null;
      $idx++;

      if (!$layer) {
        return $res;
      }
      
      if (!$layer->match($req->getServerParams()['REQUEST_URI'])) {
        return $next($req, $res);
      }

      return $layer->handle_request(
        $req
          ->withAttribute(
            'params',
            $layer->params
          ),
        $res,
        $next
      );
    };
    
    return $next($req, $res);
  }

  public function emit(): void {
    (new SapiEmitter)->emit($this->handle());
  }
}
