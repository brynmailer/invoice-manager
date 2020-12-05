<?php declare(strict_types=1);

namespace App\Middleware;

use App\Entity;

class Projects {
  public function projectExists(
    $req,
    $res,
    $next
  ) {
    $projects = Entity\Project::select([
      'where' => [
        'ID' => $req->getAttribute('params')['projectID'],
        'employerID' => $req->getAttribute('employer')->ID
      ]
    ]);

    if (\count($projects) !== 1) return $res->withStatus(404);

    return $next(
      $req->withAttribute('project', $projects[0]),
      $res
    );
  }
}
