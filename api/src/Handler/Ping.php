<?php declare(strict_types=1);

namespace InvMan\Handler;

use InvMan\Core\Server\RequestHandlerInterface;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

class Ping implements RequestHandlerInterface {
  public function handle(
    ServerRequest $request,
    JsonResponse $response
  ): JsonResponse {
    return $response
      ->withStatus(200);
  }
}
