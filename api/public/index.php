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

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Headers: Origin, Content-Type');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

$loggingMiddleware = new Middleware\Logging();
$rateLimitMiddleware = new Middleware\RateLimit();
$authMiddleware = new Middleware\Authentication();
$corsHandler = new Handler\Cors();

$authHandler = new Handler\Authentication();
$router
  ->route(BASE_PATH . '/auth/login')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->post([
    [$authHandler, 'login']
  ]);
$router
  ->route(BASE_PATH . '/auth/register')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->post([
    [$authHandler, 'register']
  ]);
$router
  ->route(BASE_PATH . '/auth/logout')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
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
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$authHandler, 'user']
  ]);

$workSessionsMiddleware = new Middleware\WorkSessions();
$workSessionsHandler = new Handler\WorkSessions();
$router
  ->route(BASE_PATH . '/work-sessions')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$workSessionsHandler, 'getWorkSessions']
  ])
  ->post([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployee'],
    [$workSessionsHandler, 'createWorkSession']
  ]);
$router
  ->route(BASE_PATH . '/work-session/:workSessionID')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->put([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployee'],
    [$workSessionsMiddleware, 'workSessionExists'],
    [$workSessionsHandler, 'editWorkSession']
  ])
  ->delete([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployee'],
    [$workSessionsMiddleware, 'workSessionExists'],
    [$workSessionsHandler, 'deleteWorkSession']
  ]);

$projectsHandler = new Handler\Projects();
$projectsMiddleware = new Middleware\Projects();
$router
  ->route(BASE_PATH . '/projects')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$projectsHandler, 'getProjects']
  ])
  ->post([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$projectsHandler, 'createProject']
  ]);
$router
  ->route(BASE_PATH . '/project/:projectID')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->put([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$projectsMiddleware, 'projectExists'],
    [$projectsHandler, 'editProject']
  ])
  ->delete([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$projectsMiddleware, 'projectExists'],
    [$projectsHandler, 'deleteProject']
  ]);

$employeesHandler = new Handler\Employees();
$employeesMiddleware = new Middleware\Employees();
$router
  ->route(BASE_PATH . '/employees')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$employeesHandler, 'getEmployees']
  ])
  ->post([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$employeesHandler, 'createEmployee']
  ]);
$router
  ->route(BASE_PATH . '/employee/:employeeID')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->put([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$employeesMiddleware, 'employeeExists'],
    [$employeesHandler, 'editEmployee']
  ])
  ->delete([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$employeesMiddleware, 'employeeExists'],
    [$employeesHandler, 'deleteEmployee']
  ]);

$invoicesHandler = new Handler\Invoices();
$invoicesMiddleware = new Middleware\Invoices();
$router
  ->route(BASE_PATH . '/invoices')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$invoicesHandler, 'getInvoices']
  ])
  ->post([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$invoicesHandler, 'createInvoice']
  ]);
$router
  ->route(BASE_PATH . '/invoice/:invoiceID')
  ->all(PRODUCTION ? [
    [$loggingMiddleware, 'logAction'],
    [$rateLimitMiddleware, 'fixedWindowDay'],
    [$rateLimitMiddleware, 'fixedWindowSec']
  ] : [])
  ->options([
    [$corsHandler, 'preflight']
  ])
  ->get([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$invoicesMiddleware, 'invoiceExists'],
    [$invoicesHandler, 'getInvoice']
  ])
  ->put([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$invoicesMiddleware, 'invoiceExists'],
    [$invoicesHandler, 'editInvoice']
  ])
  ->delete([
    [$authMiddleware, 'isAuthenticated'],
    [$authMiddleware, 'isEmployer'],
    [$invoicesMiddleware, 'invoiceExists'],
    [$invoicesHandler, 'deleteInvoice']
  ]);

$router->emit();
