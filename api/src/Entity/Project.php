<?php 

declare(strict_types=1);

namespace Api\Entity;

class Project extends Entity {
  public string $ID;
  public Employer $employer;
  public string $client;
  public string $description;
}
