<?php declare(strict_types=1);

namespace InvMan\Entity;

use InvMan\Core\Database\Entity;

use InvMan\Entity\User;

class Employer extends Entity {
  public string $ID;
  public User $user;
  public string $companyName;
}
