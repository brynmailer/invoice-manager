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

  public function logout(
    $req,
    $res,
    $next
  ) {
    unset($_SESSION['userID']);

    return $res
      ->withStatus(200);
  }

  public function user(
    $req,
    $res,
    $next
  ) {
    $result;
    switch ($_SESSION['userRole']) {
      case "employee":
        $result = Entity\Employee::select([
          'where' => [
            'userID' => $req->getAttribute('user')->ID
          ],
          'expand' => [
            'user'
          ]
        ]);
        break;

      case "employer":
        $result = Entity\Employer::select([
          'where' => [
            'userID' => $req->getAttribute('user')->ID
          ],
          'expand' => [
            'user'
          ]
        ]);
        break;
    }

    if (\count($result) !== 1) return $res->withStatus(401);

    unset($result[0]->user->password);

    return $res
      ->withStatus(200)
      ->withPayload([
        $_SESSION['userRole'] => $result[0]
      ]);
  }
}
