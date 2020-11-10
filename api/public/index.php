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
  ->route(BASE_PATH . '/auth/login')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->post([
    [$authHandler, 'login']
  ]);
$router
  ->route(BASE_PATH . '/auth/logout')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$authHandler, 'logout']
  ]);
$router
  ->route(BASE_PATH . '/auth/user')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$authHandler, 'user']
  ]);

$workSessionsMiddleware = new Middleware\WorkSessions();
$workSessionsHandler = new Handler\WorkSessions();
$router
  ->route(BASE_PATH . '/employee/:employeeID/work-sessions')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsHandler, 'getWorkSessions']
  ])
  ->post([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsHandler, 'createWorkSession']
  ]);
$router
  ->route(BASE_PATH . '/employee/:employeeID/work-session/:workSessionID')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->put([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsMiddleware, 'workSessionExists'],
    [$workSessionsHandler, 'editWorkSession']
  ])
  ->delete([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$workSessionsMiddleware, 'workSessionExists'],
    [$workSessionsHandler, 'deleteWorkSession']
  ]);

$projectsHandler = new Handler\Projects();
$router
  ->route(BASE_PATH . '/employee/:employeeID/projects')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'canAccessEmployee'],
    [$projectsHandler, 'getProjects']
  ]);

$router->emit();
