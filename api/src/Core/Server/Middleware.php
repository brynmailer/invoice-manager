<?php declare(strict_types=1);

namespace InvMan\Core\Server;

use InvMan\Core\Server\RequestHandler;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

abstract class Middleware {
  abstract public function process(
    ServerRequest $request,
    JsonResponse $response,
    RequestHandler $next
  ): JsonResponse;
}
