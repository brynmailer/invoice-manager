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

  public function canAccessEmployee(
    $req,
    $res,
    $next
  ) {
    $employee = Entity\Employee::select([
      'where' => [
        'ID' => $req->getAttribute('params')['employeeID']
      ],
      'expand' => [
        'user',
        'employer' => [
          'user'
        ]
      ]
    ]);

    if (\count($employee) === 1) {
      if (
        $employee[0]->userID !== $req->getAttribute('user')->ID &&
        $employee[0]->employer->userID !== $req->getAttribute('user')->ID
      ) {
        return $res
          ->withStatus(401);
      }

      return $next(
        $req
          ->withAttribute('employee', $employee[0]),
        $res
      );
    } else {
      return $res
        ->withStatus(404);
    }
  }
}
