<?php declare(strict_types=1);

namespace App\Framework\Database;

abstract class Entity {
  public const RELATIONS = [];
  
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

  public function save() {
    $class = \get_called_class();
    $tableName = $class::getTableName();

    $sql = "
      INSERT INTO `$tableName`
    ";
  }

  public static function select(
    array $opts = []
  ) {
    $class = \get_called_class();
    $tableName = $class::getTableName();

    $sql = "
      SELECT *
      FROM `$tableName`
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

    // Expand relationships
    if (isset($opts['expand']) && \count($opts['expand']) > 0) {
      foreach ($rows as $index => $row) {
        foreach ($opts['expand'] as $key => $value) {
          if (!\is_array($value)) {
            $relation = $value;
          } else {
            $relation = $key;
            $subRelations = $value;
          }
          $rp = new \ReflectionProperty($class, $relation);
          $subClass = $rp->getType()->getName();
          $rows[$index][$relation] = $subClass::select([
            'where' => [
              $class::RELATIONS[$relation][1] => $row[$class::RELATIONS[$relation][0]]
            ],
            'expand' => $subRelations
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

  protected static function getTableName(): string {
    $classPath = \explode('\\', \get_called_class());
    return \strtolower(
      \preg_replace(
        ['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'],
        '$1_$2',
        \end($classPath)
      )
    );
  }
}
