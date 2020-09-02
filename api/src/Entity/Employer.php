<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class Employer extends Entity {
  public string $ID;
  public string $companyName;
  public User $user;
}
