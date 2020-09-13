<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class ActionLog extends Entity {
  public const RELATIONS = [
    'user' => ['userID', 'ID']
  ];

  public string $ID;
  public string $userID;
  public string $timestamp;
  public string $ip;
  public string $userAgent;
  public string $action;

  public User $user;
}
