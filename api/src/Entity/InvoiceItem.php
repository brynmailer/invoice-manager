<?php declare(strict_types=1);

namespace InvMan\Entity;

use InvMan\Core\Database\Entity;

use InvMan\Entity\Invoice;
use InvMan\Entity\WorkSession;

class InvoiceItem extends Entity {
  public string $ID;
  public Invoice $invoice;
  public WorkSession $workSession;
}
