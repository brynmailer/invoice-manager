<?php declare(strict_types=1);

namespace App\Entity;

use Lib\Database\Entity;

class Employer extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const RELATIONS = [
    'user' => ['userID', 'ID']
  ];
  public const SCHEMA = [
    'ID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'userID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'companyName' => [
      'maxLength' => 255,
      'minLength' => 0
    ]
  ];

  public string $ID;
  public string $userID;
  public string $companyName;

  public User $user;
}
