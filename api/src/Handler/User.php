<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class User {
  public function getByID(
    $req,
    $res,
    $next
  ) {
    return $res
      ->withPayload(new Entity\User([
        'ID' => 'TEST_ID',
        'email' => 'TEST_EMAIL',
        'firstName' => 'TEST_FIRSTNAME',
        'lastName' => 'TEST_LASTNAME',
        'password' => 'TEST_PASSWORD'
      ]));
  }
}
