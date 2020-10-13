<?php declare(strict_types=1);

namespace Lib\Api;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

use MNC\PathToRegExpPHP\PathRegExpFactory;
use MNC\PathToRegExpPHP\PathRegExp;
use MNC\PathToRegExpPHP\NoMatchException;

class Layer {
  private $handle;
  private PathRegExp $pathRegExp;
  public array $params = [];
  public string $path;
  public Route $route;
  public string $method;

  public function __construct(
    string $path,
    callable $handle
  ) {
    $this->handle = $handle;
    $this->pathRegExp = PathRegExpFactory::create($path);
  }

  public function handle_request(
    ServerRequest $req,
    JsonResponse $res,
    &$next
  ): JsonResponse {
    return \call_user_func(
      $this->handle,
      $req,
      $res, 
      $next
    );
  }

  public function match(
    string $path
  ): bool {
    try {
      $match = $this->pathRegExp->match($path);
      $this->params = $match->getValues();
      $this->path = $match->getMatchedString();
      return true;
    } catch (
      NoMatchException $err
    ) {
      return false;
    }
  } 
}
