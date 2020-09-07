<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use App\Framework\Api\Router;

use App\Middleware;
use App\Handler;

$router = new Router();

$database = new Middleware\Database();
$userHandler = new Handler\User();

$router
  ->route('/invoice-manager/api/users/:userID')
  ->all([
    [$database, 'initialize']
  ])
  ->get([
    [$userHandler, 'getByID']
  ]);

$router->emit();
