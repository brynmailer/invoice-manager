<?php declare(strict_types=1);

namespace InvMan\Handler;

use InvMan\Core\Server\RequestHandler;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

class Ping extends RequestHandler{
  public function handle(
    ServerRequest $request,
    JsonResponse $response
  ): JsonResponse {
    return $response
      ->withStatus(200);
  }
}
