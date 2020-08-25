<?php declare(strict_types=1);

namespace InvMan\Entity;

use InvMan\Core\Database\Entity;

use InvMan\Entity\Employer;

class Invoice extends Entity {
  public string $ID;
  public Employer $employer;
  public string $created;
  public string $updated;
}
