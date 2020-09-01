<?php declare(strict_types=1);

namespace App\Framework\Database;

class Manager {
  private \PDO $connection;

  public function __construct() {
    $this->connection = new \PDO(
      'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME,
      DB_USERNAME,
      DB_PASSWORD,
      [
        \PDO::ATTR_PERSISTENT => true,
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
      ]
    );
  }

  public function __get($property) {
    if (property_exists($this, $property)) {
      return $this->$property;
    }
  }
}
