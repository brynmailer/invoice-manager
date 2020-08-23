<?php 

declare(strict_types=1);

namespace Api\Entity;

class Invoice extends Entity {
  public string $ID;
  public Employer $employer;
  public string $created;
  public string $updated;
}
