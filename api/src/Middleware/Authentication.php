<?php declare(strict_types=1);

namespace App\Middleware;

use App\Entity;

class Authentication {
  public function isAuthenticated(
    $req,
    $res,
    $next
  ) {
    if (isset($_SESSION['userID'])) {
      $user = Entity\User::select([
        'where' => [
          'ID' => $_SESSION['userID']
        ]
      ]);

      if (\count($user) === 1) {
        return $next(
          $req->withAttribute('user', $user[0]),
          $res
        );
      } else {
        unset($_SESSION['userID']);
      }
    }

    return $res
      ->withStatus(401);
  }
}
