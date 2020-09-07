<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class User {
  public function getByID(
    $req,
    $res,
    $next
  ) {
    $users = Entity\Invoice::select([
      'where' => [
        'ID' => $req->getAttribute('params')['userID']
      ],
      'expand' => [
        'employer' => [
          'user'
        ]
      ]
    ])[0];

    return $res
      ->withStatus(200)
      ->withPayload($users);
  }
}
