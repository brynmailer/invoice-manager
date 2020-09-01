<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Framework\Api\Router;

use App\Middleware;
use App\Handler;

$router = new Router();

$database = new Middleware\Database();
$user = new Handler\User();

$router
  ->route('/invoice-manager/api/user/:userID')
  ->all([
    [$database, 'initialize']
  ])
  ->get([
    [$user, 'getByID']
  ]);

$router->emit();
