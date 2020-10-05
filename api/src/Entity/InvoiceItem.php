<?php declare(strict_types=1);

namespace App\Entity;

use App\Framework\Database\Entity;

class InvoiceItem extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const RELATIONS = [
    'invoice' => ['invoiceID', 'ID'],
    'workSession' => ['workSessionID', 'ID']
  ];

  public string $ID;
  public string $invoiceID;
  public string $workSessionID;

  public Invoice $invoice;
  public WorkSession $workSession;
}
