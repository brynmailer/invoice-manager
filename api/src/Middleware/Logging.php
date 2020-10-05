<?php declare(strict_types=1);

namespace App\Middleware;

use App\Entity;

class Logging {
  public function logAction(
    $req,
    $res,
    $next
  ) {
    $log = new Entity\Log([
      'userID' => isset($_SESSION['userID']) ? $_SESSION['userID'] : null,
      'ip' => $req->getServerParams()['REMOTE_ADDR'],
      'userAgent' => $req->getServerParams()['HTTP_USER_AGENT'],
      'action' => $req->getServerParams()['REQUEST_URI']
    ]);

    $log
      ->save();

    return $next(
      $req,
      $res
    );
  }
}
