<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/config.php';

use Lib\Database;
use Lib\Api;

use App\Middleware;
use App\Handler;

global $dbManager;
$dbManager = new Database\Manager();

session_start();
$router = new Api\Router();

// Transfers the body of HTTP requests into the $_POST superglobal.
// Allows the request body of a HTTP PUT to be accessed by the ServerRequestFactory.
parse_str(file_get_contents("php://input"), $_POST);

$loggingMiddleware = new Middleware\Logging();
$authMiddleware = new Middleware\Authentication();

$authHandler = new Handler\Authentication();
$router
  ->route('/api/login')
  ->post([
    [$loggingMiddleware, 'logAction'],
    [$authHandler, 'login']
  ]);
$router
  ->route('/api/logout')
  ->get([
    [$loggingMiddleware, 'logAction'],
    [$authMiddleware, 'isAuthenticated'],
    [$authHandler, 'logout']
  ]);

$workSessionsMiddleware = new Middleware\WorkSessions();
$workSessionsHandler = new Handler\WorkSessions();
$router
  ->route('/api/employee/:employeeID/work-sessions')
  ->get([
    [$loggingMiddleware, 'logAction'],
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsHandler, 'getWorkSessions']
  ])
  ->post([
    [$loggingMiddleware, 'logAction'],
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsHandler, 'createWorkSession']
  ]);
$router
  ->route('/api/employee/:employeeID/work-session/:workSessionID')
  ->put([
    [$loggingMiddleware, 'logAction'],
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsMiddleware, 'workSessionExists'],
    [$workSessionsHandler, 'editWorkSession']
  ])
  ->delete([
    [$loggingMiddleware, 'logAction'],
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsMiddleware, 'workSessionExists'],
    [$workSessionsHandler, 'deleteWorkSession']
  ]);

$router->emit();
