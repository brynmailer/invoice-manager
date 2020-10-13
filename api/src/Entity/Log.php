<?php declare(strict_types=1);

namespace App\Entity;

use Lib\Database\Entity;

class Log extends Entity {
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
    'timestamp' => [
      'maxLength' => 19,
      'minLength' => 19
    ],
    'ip' => [
      'maxLength' => 45,
      'minLength' => 45
    ],
    'userAgent' => [
      'maxLength' => 255,
      'minLength' => 0
    ],
    'action' => []
  ];

  public string $ID;
  public ?string $userID;
  public string $timestamp;
  public string $ip;
  public string $userAgent;
  public string $action;

  public User $user;
}
