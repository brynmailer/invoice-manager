<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class InvoiceItem extends Entity {
  public string $ID;
  public Invoice $invoice;
  public WorkSession $workSession;
}
