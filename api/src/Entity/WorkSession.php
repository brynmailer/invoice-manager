<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class WorkSession extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const RELATIONS = [
    'employee' => ['employerID', 'ID'],
    'project' => ['projectID', 'ID']
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
