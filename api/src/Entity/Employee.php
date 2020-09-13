<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class Employee extends Entity {
  public const RELATIONS = [
    'user' => ['userID', 'ID']
    'employer' => ['employerID', 'ID']
  ];

  public string $ID;
  public string $userID;
  public string $employerID;
  // Using int to get around floating point precision errors
  // Eg. 35.42 = 3542
  public int $hourlyRate;
  public string $job;

  public User $user;
  public Employer $employer;
}
