<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class Project extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const RELATIONS = [
    'employer' => ['employerID', 'ID']
  ];

  public string $ID;
  public string $employerID;
  public string $client;
  public string $description;

  public Employer $employer;
}
