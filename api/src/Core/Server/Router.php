<?php declare(strict_types=1);

namespace InvMan\Core\Server;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

class Router {
  private array $map = [];

  public function route(
    string $method,
    string $path,
    string $handler
  ): void {
    $this->map['/^' . $method . ' \/' . \implode('\/', \array_filter(\explode('/', $path))) . '\/?$/'] = new $handler;
  }

  public function dispatch(): JsonResponse {
    $request = ServerRequestFactory::fromGlobals();
    $response = new JsonResponse(null);

    foreach ($this->map as $pattern => $handler) {
      $serverParams = $request->getServerParams();
      if (\preg_match($pattern, $serverParams['REQUEST_METHOD'] . " " . $serverParams['REQUEST_URI'])) {
        return $handler->handle($request, $response);
      }
    }

    return $response
      ->withStatus(404);
  }
}
