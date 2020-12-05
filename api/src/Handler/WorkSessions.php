<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class WorkSessions {
  public function getWorkSessions(
    $req,
    $res,
    $next
  ) {
    $workSessions = Entity\WorkSession::select([
      'expand' => [
        'project',
        'employee' => [
          'user'
        ]
      ]
    ]);

    switch ($_SESSION['userRole']) {
      case 'employer':
        return $res
          ->withStatus(200)
          ->withPayload(
            \array_filter($workSessions, function ($workSession) use (&$req) {
              return $workSession->project->employerID === $req->getAttribute('employer')->ID;
            })
          );

      case 'employee':
        return $res
          ->withStatus(200)
          ->withPayload(
            \array_filter($workSessions, function ($workSession) use (&$req) {
              return $workSession->employeeID === $req->getAttribute('employee')->ID;
            })
          );
    }
  }

  public function createWorkSession(
    $req,
    $res,
    $next
  ) {
    $workSession = new Entity\WorkSession([
      'employeeID' => $req->getAttribute('employee')->ID,
      'projectID' => $req->getParsedBody()['projectID'],
      'start' => $req->getParsedBody()['start'],
      'finish' => $req->getParsedBody()['finish'],
      'description' => $req->getParsedBody()['description']
    ]);

    $validationErrors = $workSession->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $workSession = $workSession->save();

    return $res
      ->withStatus(201)
      ->withPayload($workSession);
  }

  public function editWorkSession(
    $req,
    $res,
    $next
  ) {
    $workSession = $req->getAttribute('workSession');

    if ($req->getParsedBody()['projectID']) $workSession->projectID = $req->getParsedBody()['projectID'];
    if ($req->getParsedBody()['start']) $workSession->start = $req->getParsedBody()['start'];
    if ($req->getParsedBody()['finish']) $workSession->finish = $req->getParsedBody()['finish'];
    if ($req->getParsedBody()['description']) $workSession->description = $req->getParsedBody()['description'];

    $validationErrors = $workSession->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $workSession = $workSession->save();

    return $res
      ->withStatus(200)
      ->withPayload($workSession);
  }

  public function deleteWorkSession(
    $req,
    $res,
    $next
  ) {
    Entity\WorkSession::delete([
      'where' => [
        'ID' => $req->getAttribute('params')['workSessionID'],
        'employeeID' => $req->getAttribute('employee')->ID
      ]
    ]);

    return $res->withStatus(204);
  }
}
