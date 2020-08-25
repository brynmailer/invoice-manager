<?php declare(strict_types=1);

namespace InvMan\Entity;

use InvMan\Core\Database\Entity;

use InvMan\Entity\Employer;

class Project extends Entity {
  public string $ID;
  public Employer $employer;
  public string $client;
  public string $description;
}
