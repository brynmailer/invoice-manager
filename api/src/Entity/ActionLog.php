<?php declare(strict_types=1);

namespace InvMan\Entity;

use InvMan\Core\Database\Entity;

use InvMan\Entity\User;

class ActionLog extends Entity {
  public string $ID;
  public User $user;
  public string $timestamp;
  public string $ip;
  public string $userAgent;
  public string $action;
}
