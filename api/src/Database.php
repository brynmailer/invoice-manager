<?php

declare(strict_types=1);

namespace Api;

class Database {
  private \PDO $database;

  public function __construct($config) {
    $this->database = new \PDO(
      'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['name'],
      $config['database']['username'],
      $config['database']['password']
    );
  }
}
