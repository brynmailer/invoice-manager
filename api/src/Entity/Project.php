<?php declare(strict_types=1);

namespace App\Entity;

use Lib\Database\Entity;

class Project extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const RELATIONS = [
    'employer' => ['employerID', 'ID']
  ];
  public const SCHEMA = [
    'ID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'employerID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'client' => [
      'maxLength' => 255,
      'minLength' => 0
    ],
    'description' => []
  ];

  public string $ID;
  public string $employerID;
  public string $title;
  public string $client;
  public string $description;

  public Employer $employer;
}
