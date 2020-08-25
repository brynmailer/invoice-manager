<?php declare(strict_types=1);

namespace InvMan\Handler;

use InvMan\Core\Server\RequestHandlerInterface;

use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;

use InvMan\Entity\Employer;

class Login implements RequestHandlerInterface {
  public function handle(
    ServerRequest $request,
    JsonResponse $response
  ): JsonResponse {
    return $response
      ->withStatus(200)
      ->withPayload(new Employer([
        'ID' => 'TEST_ID',
        'user' => [
          'ID' => 'TEST_ID',
          'email' => 'TEST_EMAIL',
          'firstName' => 'TEST_FIRSTNAME',
          'lastName' => 'TEST_LASTNAME',
          'password' => 'TEST_PASSWORD'
        ],
        'companyName' => 'TEST_COMPANYNAME'
      ]));
  }
}
