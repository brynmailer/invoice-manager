<?php declare(strict_types=1);

namespace App\Middleware;

use App\Entity;

class Authentication {
  public function isAuthenticated(
    $req,
    $res,
    $next
  ) {
    if (!isset($_SESSION['userID'])) return $res->withStatus(401);

    $user;

    switch ($_SESSION['userRole']) {
      case 'employee':
        $user = Entity\Employee::select([
          'where' => [
            'userID' => $_SESSION['userID']
          ],
          'expand' => [
            'user'
          ]
        ]);
        break;

      case 'employer':
        $user = Entity\Employer::select([
          'where' => [
            'userID' => $_SESSION['userID']
          ],
          'expand' => [
            'user'
          ]
        ]);
        break;
    }

    if (\count($user) !== 1){
      unset($_SESSION['userID']);
      return $res->withStatus(401);
    }

    return $next(
      $req->withAttribute($_SESSION['userRole'], $user[0]),
      $res
    );
  }

  public function isEmployer(
    $req,
    $res,
    $next
  ) {
    if ($_SESSION['userRole'] !== 'employer') return $res->withStatus(401);

    return $next(
      $req,
      $res
    );
  }

  public function isEmployee(
    $req,
    $res,
    $next
  ) {
    if ($_SESSION['userRole'] !== 'employee') return $res->withStatus(401);

    return $next(
      $req,
      $res
    );
  }
}
