<?php declare(strict_types=1);

namespace InvMan\Core\Server;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

interface RequestHandlerInterface {
  public function handle(
    ServerRequest $request,
    JsonResponse $response
  ): JsonResponse;
}
