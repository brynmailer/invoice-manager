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

  public static function select(
    array $opts = []
  ) {
    $class = \get_called_class();
    $classPath = \explode('\\', $class);
    $table = \strtolower(
      \preg_replace(
        ['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'],
        '$1_$2',
        \end($classPath)
      )
    );

    $sql = "
      SELECT *
      FROM `$table`
    ";
    
    // Build SQL query string
    if (isset($opts['where']) && \count($opts['where']) > 0) {
      $index = 0;
      foreach (\array_keys($opts['where']) as $key) {
        if ($index > 0) {
          $sql .= " AND `$key` = :$key";
        } else {
          $sql .= " WHERE `$key` = :$key";
        }
        $index++;
      }
    }

    global $dbManager;
    $statement = $dbManager
      ->connection
      ->prepare($sql);
    
    // Bind params
    if (isset($opts['where']) && \count($opts['where']) > 0) {
      foreach ($opts['where'] as $key => &$value) {
        $statement->bindParam(":$key", $value);
      }
    }

    $statement->execute();
    $rows = $statement->fetchAll(\PDO::FETCH_ASSOC);

    if (isset($opts['relations']) && \count($opts['relations']) > 0) {
      foreach ($rows as $index => $row) {
        foreach ($opts['relations'] as $key => $value) {
          $primaryKey = \explode('.', $key);
          $foreignKey = \explode('.', $value);
          $rows[$index][$foreignKey[0]] = (
            \implode('\\', \array_slice($classPath, 0, 2)) .
            '\\' .
            \ucfirst($foreignKey[0])
          )::select([
            'where' => [
              $foreignKey[1] => $row[$primaryKey[1]]
            ]
          ])[0];
        }
      }
    }

    return \array_map(
      function ($row) use ($class) {
        return new $class($row);
      },
      $rows
    );
  }
}
