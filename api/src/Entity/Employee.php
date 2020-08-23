<?php 

declare(strict_types=1);

namespace Api\Entity;

class Employee extends Entity {
  public string $ID;
  public User $user;
  public string $employerID;
  // Using int to get around floating point precision errors
  // Eg. 35.42 = 3542
  public int $hourlyRate;
  public string $job;
}
