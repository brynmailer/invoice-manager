<?php declare(strict_types=1);

namespace InvMan\Core\Server;

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

class Router {
  private array $map = [];
  private array $methods = [
    'GET',
    'POST',
    'PUT',
    'DELETE',
    '*'
  ];

  public function route(
    string $method,
    string $path,
    string $handler
  ): void {
    if (\in_array($method, $this->methods)) {
      $methodSelector = $method === '*' ? '(GET|POST|PUT|DELETE)' : $method;
      $this->map[
        '/^' .
        $methodSelector .
        ' \/' .
        \implode('\/', \array_filter(\explode('/', $path))) .
        '\/?$/'
      ] = new $handler;
    } else {
      throw new Exception('Invalid HTTP method supplied to Router::route');
    }
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
