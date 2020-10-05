<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use App\Framework\Database;
use App\Framework\Api;

use App\Middleware;
use App\Handler;

global $dbManager;
$dbManager = new Database\Manager();

session_start();
$router = new Api\Router();

$authMiddleware = new Middleware\Authentication();

$authHandler = new Handler\Authentication();
$router
  ->route('/api/login')
  ->post([
    [$authHandler, 'login']
  ]);
$router
  ->route('/api/logout')
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$authHandler, 'logout']
  ]);

$router->emit();
