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

// Transfers and decodes the JSON body of HTTP requests into the $_POST superglobal.
// Allows Laminas Diactoros' ServerRequestFactory to understand JSON bodies.
$_POST = json_decode(file_get_contents("php://input"), true);

$loggingMiddleware = new Middleware\Logging();
$rateLimitMiddleware = new Middleware\RateLimit();
$authMiddleware = new Middleware\Authentication();

$authHandler = new Handler\Authentication();
$router
  ->route('/api/auth/login')
  ->post([
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$authHandler, 'login']
  ]);
$router
  ->route('/api/auth/logout')
  ->get([
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$authMiddleware, 'isAuthenticated'],
    [$authHandler, 'logout']
  ]);
$router
  ->route('/api/auth/me')
  ->get([
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$authMiddleware, 'isAuthenticated'],
    [$authHandler, 'me']
  ]);

$workSessionsMiddleware = new Middleware\WorkSessions();
$workSessionsHandler = new Handler\WorkSessions();
$router
  ->route('/api/employee/:employeeID/work-sessions')
  ->get([
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsHandler, 'getWorkSessions']
  ])
  ->post([
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsHandler, 'createWorkSession']
  ]);
$router
  ->route('/api/employee/:employeeID/work-session/:workSessionID')
  ->put([
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsMiddleware, 'workSessionExists'],
    [$workSessionsHandler, 'editWorkSession']
  ])
  ->delete([
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsMiddleware, 'workSessionExists'],
    [$workSessionsHandler, 'deleteWorkSession']
  ]);

$projectsHandler = new Handler\Projects();
$router
  ->route('/api/employee/:employeeID/projects')
  ->get([
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$projectsHandler, 'getProjects']
  ]);

$router->emit();
