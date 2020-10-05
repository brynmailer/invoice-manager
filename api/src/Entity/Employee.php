<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class Employee extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const RELATIONS = [
    'user' => ['userID', 'ID'],
    'employer' => ['employerID', 'ID']
  ];

  public string $ID;
  public string $userID;
  public string $employerID;
  public string $hourlyRate;
  public string $job;

  public User $user;
  public Employer $employer;
}
