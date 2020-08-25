<?php declare(strict_types=1);

namespace InvMan\Core\Database;

use InvMan\Core\Database\Entity;

class Manager {
  private \PDO $database;

  public function __construct() {
    $this->database = new \PDO(
      'mysql:host=localhost;dbname=invoice-manager',
      'invoice-manager',
      'murtel12'
    );
  }

  public function select(
    string $entity,
    array $options
  ): Entity {
    
  }
}
