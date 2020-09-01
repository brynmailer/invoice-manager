<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class User extends Entity {
  public string $ID;
  public string $email;
  public string $firstName;
  public string $lastName;
  public string $password;
}
