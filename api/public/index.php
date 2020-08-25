<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use InvMan\Core\Server\Router;

use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;


$router = new Router();

$router->route(
  'GET',
  '/invoice-manager/api',
  'InvMan\Handler\Ping'
);

$router->route(
  'GET',
  '/invoice-manager/api/login',
  'InvMan\Handler\Login'
);

(new SapiEmitter)->emit($router->dispatch());
