<?php declare(strict_types=1);

namespace App\Framework\Database;

abstract class Entity {
  public const PRIMARY_KEY = '';
  public const RELATIONS = [];
  public const SCHEMA = [];
  
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

  public function validate() {
    $class = \get_called_class();
    $errors = [];

    foreach ($class::SCHEMA as $property => $rules) {
      if (isset($this->{$property})) {
        foreach ($rules as $key => $value) {
          $rp = new \ReflectionProperty($class, $property);
          if ($rp->getType()->getName() === 'string') {
            switch ($key) {
              case 'maxLength':
                if (\strlen($this->{$property}) > $value) $errors[$property][$key] = "Must not contain more than ${value} characters.";
                break;
              case 'minLength':
                if (\strlen($this->{$property}) < $value) $errors[$property][$key] = "Must not contain less than ${value} characters.";
                break;
            }
          } else if ($rp->getType()->getType() === 'int') {
            switch ($key) {
              case 'maxLength':
                if (\strlen((string)$this->{$property}) > $value) $errors[$property][$key] = "Must not contain more than ${value} digits.";
                break;
              case 'minLength':
                if (\strlen((string)$this->{$property}) < $value) $errors[$property][$key] = "Must not contain less than ${value} digits.";
                break;
              case 'maxValue':
                if ($this->{$property} > $value) $errors[$property][$key] = "Must not be greater than ${value}.";
                break;
              case 'minValue':
                if ($this->{$property} < $value) $errors[$property][$key] = "Must not be less than ${value}.";
                break;
            }
          }
        }
      }
    }

    return $errors;
  }

  public function save() {
    global $dbManager;
    $class = \get_called_class();
    $properties = \get_object_vars($this);
    $tableName = $class::getTableName();
    $primaryKey = $class::PRIMARY_KEY;

    foreach (\array_keys($class::RELATIONS) as $key) {
      unset($properties[$key]);
    }

    if (!isset($this->{$class::PRIMARY_KEY})) {
      $sql = "INSERT INTO `$tableName` (";
      $sql .= "$primaryKey, ";
      $keys = \array_keys($properties);

      $index = 0;
      foreach ($keys as $key) {
        if ($index === \count($keys) - 1) {
          $sql .= "$key) VALUES (";
        } else {
          $sql .= "$key, ";
        }
        $index++;
      }

      $statement = $dbManager
        ->connection
        ->prepare("SELECT UUID() as PK");
      $statement->execute();
      $newPK = $statement->fetchAll(\PDO::FETCH_ASSOC)[0]['PK'];

      $sql .= "'$newPK', ";
      $index = 0;
      foreach ($keys as $key) {
        if ($index === \count($keys) - 1) {
          $sql .= ":$key)";
        } else {
          $sql .= ":$key, ";
        }
        $index++;
      }

      $statement = $dbManager
        ->connection
        ->prepare($sql);
      
      foreach ($properties as $key => &$value) {
        $statement->bindParam(":$key", $value);
      }

      $statement->execute();

      return $class::select([
        'where' => [
          $primaryKey => $newPK
        ]
      ])[0];
    } else {
      $PK = $this->{$primaryKey};
      unset($properties[$primaryKey]);

      $sql = "UPDATE `$tableName` SET ";

      $keys = \array_keys($properties);
      $index = 0;
      foreach ($keys as $key) {
        if ($index === \count($keys) - 1) {
          $sql .= "$key = :$key ";
        } else {
          $sql .= "$key = :$key, ";
        }
        $index++;
      }

      $sql .= "WHERE $primaryKey = :$primaryKey";

      $statement = $dbManager
        ->connection
        ->prepare($sql);
      
      foreach ($properties as $key => &$value) {
        $statement->bindParam(":$key", $value);
      }
      $statement->bindParam(":$primaryKey", $PK);

      $statement->execute();

      return $class::select([
        'where' => [
          $primaryKey => $PK
        ]
      ])[0];
    }
  }

  public static function delete(
    array $opts = []
  ) {
    $class = \get_called_class();
    $tableName = $class::getTableName();

    $sql = "DELETE FROM `$tableName`";
    
    // Add WHERE clause
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
    
    // Add WHERE clause
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
    return \lcfirst(\end($classPath));
  }
}
