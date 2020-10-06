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

    $_SESSION['userID'] = $users[0]->ID;
    unset($users[0]->password);

    return $res
      ->withStatus(200)
      ->withPayload([
        'user' => $users[0]
      ]);
  }

  public function logout(
    $req,
    $res,
    $next
  ) {
    unset($_SESSION['userID']);
  }
}
