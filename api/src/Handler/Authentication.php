<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class Authentication {
  public function login(
    $req,
    $res,
    $next
  ) {
    $users = Entity\User::select([ 
      'where' => [ 
        'email' => $req->getParsedBody()['email']
      ]
    ]);

    if (\count($users) !== 1) return $res->withStatus(401);

    if (!\password_verify($req->getParsedBody()['password'], $users[0]->password)) return $res->withStatus(401);

    $result;
    switch ($req->getParsedBody()['role']) {
      case "employee":
        $result = Entity\Employee::select([
          'where' => [
            'userID' => $users[0]->ID
          ],
          'expand' => [
            'user' 
          ]
        ]);

        if (\count($result) !== 1) {
          return $res->withStatus(401);
        }

        break;

      case "employer":
        $result = Entity\Employer::select([
          'where' => [
            'userID' => $users[0]->ID
          ],
          'expand' => [
            'user' 
          ]
        ]);

        if (\count($result) !== 1) {
          return $res->withStatus(401);
        }

        break;

      default:
        return $res->withStatus(400);
        break;
    }

    unset($users);

    $_SESSION['userID'] = $result[0]->user->ID;
    $_SESSION['userRole'] = $req->getParsedBody()['role'];
    unset($result[0]->user->password);

    return $res
      ->withStatus(200)
      ->withPayload([
        $req->getParsedBody()['role'] => $result[0]
      ]);
  }

  public function register(
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

    $employer = new Entity\Employer([
      'userID' => $user->ID,
      'companyName' => $req->getParsedBody()['companyName'],
    ]);

    $validationErrors = $employer->validate();

    if (\count($validationErrors) > 0) {
      return $res
        ->withStatus(400)
        ->withPayload([
          'error' => [
            'validation' => $validationErrors
          ]
        ]);
    }

    $employer = $employer->save();
    $employer->user = $user;

    $_SESSION['userID'] = $employer->user->ID;
    $_SESSION['userRole'] = 'employer';
    unset($employer->user->password);

    return $res
      ->withStatus(201)
      ->withPayload([
        'employer' => $employer
      ]);
  }

  public function logout(
    $req,
    $res,
    $next
  ) {
    unset($_SESSION['userID']);
    unset($_SESSION['userRole']);

    return $res
      ->withStatus(200);
  }

  public function user(
    $req,
    $res,
    $next
  ) {
    unset($req->getAttribute($_SESSION['userRole'])->user->password);

    return $res
      ->withStatus(200)
      ->withPayload([
        $_SESSION['userRole'] => $req->getAttribute($_SESSION['userRole'])
      ]);
  }
}
