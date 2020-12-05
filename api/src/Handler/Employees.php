<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class Employees {
  public function getEmployees(
    $req,
    $res,
    $next
  ) {
    return $res
      ->withStatus(200)
      ->withPayload(
        Entity\Employee::select([
          'where' => [
            'employerID' => $req->getAttribute('employer')->ID
          ],
          'expand' => [
            'user'
          ]
        ])
      );
  }

  public function createEmployee(
    $req,
    $res,
    $next
  ) {
    $user = new Entity\User([
      'email' => $req->getParsedBody()['email'],
      'firstName' => $req->getParsedBody()['firstName'],
      'lastName' => $req->getParsedBody()['lastName'],
      'password' => \password_hash($req->getParsedBody()['password'], PASSWORD_BCRYPT)
    ]);

    $validationErrors = $user->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $user = $user->save();

    $employee = new Entity\Employee([
      'userID' => $user->ID,
      'employerID' => $req->getAttribute('employer')->ID,
      'hourlyRate' => $req->getParsedBody()['hourlyRate'],
      'job' => $req->getParsedBody()['job']
    ]);

    $validationErrors = $employee->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $employee = $employee->save();
    $employee->user = $user;

    return $res
      ->withStatus(201)
      ->withPayload($employee);
  }

  public function editEmployee(
    $req,
    $res,
    $next
  ) {
    $employee = $req->getAttribute('employee');

    $user = Entity\User::select([
      'where' => [
        'ID' => $employee->userID
      ]
    ])[0];

    if ($req->getParsedBody()['email']) $user->email = $req->getParsedBody()['email'];
    if ($req->getParsedBody()['firstName']) $user->firstName = $req->getParsedBody()['firstName'];
    if ($req->getParsedBody()['lastName']) $user->lastName = $req->getParsedBody()['lastName'];
    if ($req->getParsedBody()['password']) $user->password = \password_hash($req->getParsedBody()['description'], PASSWORD_BCRYPT);

    $validationErrors = $user->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $user = $user->save();

    if ($req->getParsedBody()['hourlyRate']) $employee->hourlyRate = $req->getParsedBody()['hourlyRate'];
    if ($req->getParsedBody()['job']) $employee->job = $req->getParsedBody()['job'];

    $validationErrors = $employee->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $employee = $employee->save();
    $employee->user = $user;

    return $res
      ->withStatus(200)
      ->withPayload($employee);
  }

  public function deleteEmployee(
    $req,
    $res,
    $next
  ) {
    Entity\Employee::delete([
      'where' => [
        'ID' => $req->getAttribute('employee')->ID
      ]
    ]);

    Entity\User::delete([
      'where' => [
        'ID' => $req->getAttribute('employee')->userID
      ]
    ]);

    return $res->withStatus(204);
  }
}
