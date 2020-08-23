<?php

error_reporting(E_ALL & ~E_NOTICE);
session_start();

return [
  'routeMap' => [
    'GET /' => 'ping',
  ],

  'database' => [
    'host' => 'localhost',
    'name' => 'invoice-manager',
    'username' => 'invoice-manager',
    'password' => 'password'
  ]
];
