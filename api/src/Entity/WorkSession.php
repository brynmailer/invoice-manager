<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class WorkSession extends Entity {
  public string $ID;
  public Employee $employee;
  public Project $project;
  public string $start;
  public string $finish;
  public string $description;
}
