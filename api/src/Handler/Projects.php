<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class Projects {
  public function getProjects(
    $req,
    $res,
    $next
  ) {
    return $res
      ->withStatus(200)
      ->withPayload(
        Entity\Project::select([
          'where' => [
            'employerID' => $req->getAttribute('employee')->employerID
          ]
        ])
      );
  }
}
