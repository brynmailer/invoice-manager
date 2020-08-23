<?php 

declare(strict_types=1);

namespace Api\Entity;

class InvoiceItem extends Entity {
  public string $ID;
  public Invoice $invoice;
  public WorkSession $workSession;
}
