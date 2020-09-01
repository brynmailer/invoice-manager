<?php declare(strict_types=1);

namespace App\Framework\Database;

abstract class Entity {
  public function __construct($args) {
    foreach ($args as $key => $value) {
      if (\property_exists($this, $key)) {
        $rp = new \ReflectionProperty(\get_class($this), $key);
        $className = $rp->getType()->getName();
        if (class_exists($className)) {
          $this->{$key} = new $className($value);
        } else {
          $this->{$key} = $value;
        }
      }
    }
  }

  public static function select() {
    $class = \get_called_class();
    $table = \strtolower(
      \preg_replace(
        ['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'],
        '$1_$2',
        \end(\explode('\\', $class))
      )
    );

    $sql = "
      SELECT *
      FROM $table
    ";

    global $dbManager;
    $statement = $dbManager
      ->connection
      ->prepare($sql);

    $statement->execute();
    return \array_map(
      function ($row) use ($class) {
        return new $class($row);
      },
      $statement->fetchAll(\PDO::FETCH_ASSOC)
    );
  }
}
