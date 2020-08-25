<?php declare(strict_types=1);

namespace InvMan\Entity;

use InvMan\Core\Database\Entity;

class User extends Entity {
  public string $ID;
  public string $email;
  public string $firstName;
  public string $lastName;
  public string $password;
}
