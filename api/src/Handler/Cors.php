<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class Cors {
  public function preflight(
    $req,
    $res,
    $next
  ) {
    return $res
      ->withStatus(200);
  }
}
