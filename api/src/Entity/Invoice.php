<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class Invoice extends Entity {
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
    'created' => [
      'maxLength' => 19,
      'minLength' => 19
    ],
    'updated' => [
      'maxLength' => 19,
      'minLength' => 19
    ]
  ];

  public string $ID;
  public string $employerID;
  public string $created;
  public string $updated;

  public Employer $employer;
}
