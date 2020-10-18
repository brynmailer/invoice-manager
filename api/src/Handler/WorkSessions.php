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
    $workSession = new Entity\WorkSession([
      'ID' => $req->getAttribute('params')['workSessionID'],
      'employeeID' => $req->getAttribute('params')['employeeID'],
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
