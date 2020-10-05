<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class User extends Entity {
  public const PRIMARY_KEY = 'ID';

  public string $ID;
  public string $email;
  public string $firstName;
  public string $lastName;
  public string $password;
}
