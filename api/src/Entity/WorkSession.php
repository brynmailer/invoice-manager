<?php declare(strict_types=1);

namespace App\Entity;

use Lib\Database\Entity;

class WorkSession extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const RELATIONS = [
    'employee' => ['employerID', 'ID'],
    'project' => ['projectID', 'ID']
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
    'projectID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'start' => [
      'maxLength' => 19,
      'minLength' => 19
    ],
    'finish' => [
      'maxLength' => 19,
      'minLength' => 19
    ],
    'description' => []
  ];

  public string $ID;
  public string $employeeID;
  public string $projectID;
  public string $start;
  public string $finish;
  public string $description;

  public Employee $employee;
  public Project $project;
}
