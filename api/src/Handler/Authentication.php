<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;
use Ramsey\Uuid\Uuid;

class Authentication {
  public function login(
    $req,
    $res,
    $next
  ) {
    $test = new Entity\User([
      'ID' => '8e069953-06b9-11eb-983a-84fdd1be0091',
      'email' => 'brydiupero@gmail.com',
      'firstName' => 'Bryan',
      'lastName' => 'Mailer'
    ]);

    return $res
      ->withStatus(200)
      ->withPayload($test->delete([
        'where' => [
          'ID' => '8e069953-06b9-11eb-983a-84fdd1be0091'
        ]
      ]));
  }
}
