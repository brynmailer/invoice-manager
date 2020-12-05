<?php declare(strict_types=1);

namespace App\Middleware;

use App\Entity;

class WorkSessions {
  public function workSessionExists(
    $req,
    $res,
    $next
  ) {
    $workSession = Entity\WorkSession::select([
      'where' => [
        'ID' => $req->getAttribute('params')['workSessionID'],
        'employeeID' => $req->getAttribute('employee')->ID
      ]
    ]);

    if (\count($workSession) !== 1) return $res->withStatus(404);

    return $next(
      $req->withAttribute('workSession', $workSession[0]),
      $res
    );
  }
}
