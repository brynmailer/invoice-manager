<?php declare(strict_types=1);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$dotenv->ifPresent('PRODUCTION')->isBoolean();
$dotenv->required('BASE_PATH');
$dotenv->ifPresent('RATELIMIT_WINDOW')->isInteger();
$dotenv->ifPresent('REQUESTS_PER_WINDOW')->isInteger();
$dotenv->required('DB_HOST')->notEmpty();
$dotenv->required('DB_NAME')->notEmpty();
$dotenv->required('DB_USERNAME')->notEmpty();
$dotenv->required('DB_PASSWORD')->notEmpty();

define('PRODUCTION', $_ENV['PRODUCTION'] ? (strcasecmp($_ENV['PRODUCTION'], 'true') ? false : true) : false);
define('BASE_PATH', $_ENV['BASE_PATH']);
define('DB_HOST', $_ENV['DB_HOST']);
define('DB_NAME', $_ENV['DB_NAME']);
define('DB_USERNAME', $_ENV['DB_USERNAME']);
define('DB_PASSWORD', $_ENV['DB_PASSWORD']);
define('RATELIMIT_WINDOW', $_ENV['RATELIMIT_WINDOW'] ?? 86400);
define('REQUESTS_PER_WINDOW', $_ENV['REQUESTS_PER_WINDOW'] ?? 500);
