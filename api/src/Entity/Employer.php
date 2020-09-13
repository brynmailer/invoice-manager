<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class Employer extends Entity {
  public const RELATIONS = [
    'user' => ['userID', 'ID']
  ];

  public string $ID;
  public string $companyName;
  public string $userID;

  public User $user;
}
