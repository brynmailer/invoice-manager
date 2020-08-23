<?php 

declare(strict_types=1);

namespace Api\Entity;

class ActionLog extends Entity {
  public string $ID;
  public User $user;
  public string $timestamp;
  public string $ip;
  public string $userAgent;
  public string $action;
}
