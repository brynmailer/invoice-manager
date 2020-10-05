<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use App\Framework\Api\Router;

use App\Middleware;
use App\Handler;

$router = new Router();

$databaseMiddleware = new Middleware\Database();

$authenticationHandler = new Handler\Authentication();
$router
  ->route('/api/login')
  ->post([
    [$databaseMiddleware, 'initialize'],
    [$authenticationHandler, 'login']
  ]);

$router->emit();
