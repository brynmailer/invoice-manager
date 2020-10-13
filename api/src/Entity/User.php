<?php declare(strict_types=1);

namespace App\Entity;

use Lib\Database\Entity;

class User extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const SCHEMA = [
    'ID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'email' => [
      'maxLength' => 255,
      'minLength' => 3
    ],
    'firstName' => [
      'maxLength' => 255,
      'minLength' => 0
    ],
    'lastName' => [
      'maxLength' => 255,
      'minLength' => 0
    ],
    'password' => [
      'maxLength' => 60,
      'minLength' => 60
    ]
  ];

  public string $ID;
  public string $email;
  public string $firstName;
  public string $lastName;
  public string $password;
}
