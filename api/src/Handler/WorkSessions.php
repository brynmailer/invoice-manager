<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class WorkSessions {
  public function getWorkSessions(
    $req,
    $res,
    $next
  ) {
    return $res
      ->withStatus(200)
      ->withPayload(
        Entity\WorkSession::select([
          'where' => [
            'employeeID' => $req->getAttribute('employee')->ID
          ],
          'expand' => [
            'project'
          ]
        ])
      );
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
    $workSessions = Entity\WorkSession::select([
      'where' => [
        'ID' => $req->getAttribute('params')['workSessionID'],
        'employeeID' => $req->getAttribute('params')['employeeID']
      ]
    ]);

    if (\count($workSessions) !== 1) return $res->withStatus(404);

    if ($req->getParsedBody()['projectID']) $workSessions[0]->projectID = $req->getParsedBody()['projectID'];
    if ($req->getParsedBody()['start']) $workSessions[0]->start = $req->getParsedBody()['start'];
    if ($req->getParsedBody()['finish']) $workSessions[0]->finish = $req->getParsedBody()['finish'];
    if ($req->getParsedBody()['description']) $workSessions[0]->description = $req->getParsedBody()['description'];

    $validationErrors = $workSessions[0]->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $workSession = $workSessions[0]->save();

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
        'employeeID' => $req->getAttribute('params')['employeeID']
      ]
    ]);

    return $res->withStatus(204);
  }
}
