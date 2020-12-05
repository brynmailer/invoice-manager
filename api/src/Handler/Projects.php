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
            'employerID' => $_SESSION['userRole'] === 'employee'
              ? $req->getAttribute('employee')->employerID
              : $req->getAttribute('employer')->ID
          ]
        ])
      );
  }

  public function createProject(
    $req,
    $res,
    $next
  ) {
    $project = new Entity\Project([
      'employerID' => $req->getAttribute('employer')->ID,
      'title' => $req->getParsedBody()['title'],
      'client' => $req->getParsedBody()['client'],
      'description' => $req->getParsedBody()['description']
    ]);

    $validationErrors = $project->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $project = $project->save();

    return $res
      ->withStatus(201)
      ->withPayload($project);
  }

  public function editProject(
    $req,
    $res,
    $next
  ) {
    $project = $req->getAttribute('project');

    if ($req->getParsedBody()['title']) $project->title = $req->getParsedBody()['title'];
    if ($req->getParsedBody()['client']) $project->client = $req->getParsedBody()['client'];
    if ($req->getParsedBody()['description']) $project->description = $req->getParsedBody()['description'];

    $validationErrors = $project->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $project = $project->save();

    return $res
      ->withStatus(200)
      ->withPayload($project);
  }

  public function deleteProject(
    $req,
    $res,
    $next
  ) {
    Entity\Project::delete([
      'where' => [
        'ID' => $req->getAttribute('params')['projectID'],
        'employerID' => $req->getAttribute('employer')->ID
      ]
    ]);

    return $res->withStatus(204);
  }
}
