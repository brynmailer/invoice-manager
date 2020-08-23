<?php

require __DIR__ . '/../autoloader.php';

use Api\Exception;
use Api\Dispatcher;
use Api\Container;

try {

  $config = include __DIR__ . '/../config.php' ?: [];
  $container = new Container(
    $_SERVER,
    $_GET,
    $_POST,
    $_COOKIE,
    $_SESSION,
    $config
  );
  $dispatcher = new Dispatcher($container);
  $response = $dispatcher->dispatch(explode('api', $_SERVER['REQUEST_URI'])[1], $_SERVER['REQUEST_METHOD']);

} catch (Exception\NoMatchingRoute $e) {

  $statusMsg = $e->getMessage() ?: 'Not Found';
  $statusCode = $e->getCode();

} catch (\Exception $e) {

  $statusMsg = $e->getMessage() ?: 'Internal Server Error';
  $statusCode = $e->getCode() ?: 500;

} finally {

  header("HTTP/1.1 $statusCode $statusMsg");
  header('Content-Type: application/json');
  echo json_encode($response);

}
