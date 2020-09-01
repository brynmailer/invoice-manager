<?php declare(strict_types=1);

namespace App\Middleware;

use App\Framework\Database\Manager;

class Database {
  public function initialize(
    $req,
    $res,
    $next
  ) {
    global $dbManager;
    $dbManager = new Manager();

    return $next(
      $req,
      $res
    );
  }
}
