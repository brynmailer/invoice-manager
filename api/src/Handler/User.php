<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class User {
  public function getAll(
    $req,
    $res,
    $next
  ) {
    $users = Entity\Employer::select([
      'relations' => [
        'employer.userID' => 'user.ID'
      ]
    ]);

    return $res
      ->withStatus(200)
      ->withPayload($users);
  }
}
