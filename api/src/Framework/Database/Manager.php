<?php declare(strict_types=1);

namespace App\Framework\Database;

class Manager {
  private \PDO $database;

  public function __construct() {
    $this->database = new \PDO(
      'mysql:host=localhost;dbname=invoice-manager',
      'invoice-manager',
      'murtel12',
      [
        'PDO::ATTR_PERSISTENT' => true
      ]
    );
  }

  public function select(
    string $entity,
    array $options
  ): Entity {
    $sql = '
      SELECT *
      FROM :entity
      WHERE
    ';
  }
}
