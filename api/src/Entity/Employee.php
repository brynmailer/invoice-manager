<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class Employee extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const RELATIONS = [
    'user' => ['userID', 'ID'],
    'employer' => ['employerID', 'ID']
  ];
  public const SCHEMA = [
    'ID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'userID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'employerID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'hourlyRate' => [
      'maxLength' => 15,
      'minLength' => 0
    ],
    'job' => []
  ];

  public string $ID;
  public string $userID;
  public string $employerID;
  public string $hourlyRate;
  public string $job;

  public User $user;
  public Employer $employer;
}
