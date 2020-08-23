<?php 

declare(strict_types=1);

namespace Api\Entity;

class Employer extends Entity {
  public string $ID;
  public User $user;
  public string $companyName;
}
