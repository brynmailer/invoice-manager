<?php declare(strict_types=1);

namespace App\Middleware;

class Database {
  public function initialize(
    $req,
    $res,
    $next
  ) {
    return $next(
      $req,
      $res
        ->withStatus(200)
    );
  }
}
