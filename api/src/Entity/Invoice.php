<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class Invoice extends Entity {
  public const RELATIONS = [
    'employer' => ['employerID', 'ID']
  ];

  public string $ID;
  public string $employerID;
  public string $created;
  public string $updated;

  public Employer $employer;
}
