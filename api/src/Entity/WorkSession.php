<?php declare(strict_types=1);

namespace InvMan\Entity;

use InvMan\Core\Database\Entity;

use InvMan\Entity\Employee;
use InvMan\Entity\Project;

class WorkSession extends Entity {
  public string $ID;
  public Employee $employee;
  public Project $project;
  public string $start;
  public string $finish;
  public string $description;
}
