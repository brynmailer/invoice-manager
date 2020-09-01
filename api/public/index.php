<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Framework\Server\Router;

use App\Entity\User;

$router = new Router();

$router
  ->route('/invoice-manager/api/user/:userID')
  ->get([
    function ($req, $res, $next) {
      return $res
        ->withStatus(200)
        ->withPayload(new User([
          'ID' => 'TEST_ID',
          'email' => 'TEST_EMAIL',
          'firstName' => 'TEST_FIRSTNAME',
          'lastName' => 'TEST_LASTNAME',
          'password' => 'TEST_PASSWORD'
        ]));
    }
  ]);

$router->emit();
