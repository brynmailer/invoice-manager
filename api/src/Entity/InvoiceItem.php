<?php declare(strict_types=1);

namespace App\Entity;

use Lib\Database\Entity;

class InvoiceItem extends Entity {
  public const PRIMARY_KEY = 'ID';
  public const RELATIONS = [
    'invoice' => ['invoiceID', 'ID'],
    'workSession' => ['workSessionID', 'ID']
  ];
  public const SCHEMA = [
    'ID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'invoiceID' => [
      'maxLength' => 36,
      'minLength' => 36
    ],
    'workSessionID' => [
      'maxLength' => 36,
      'minLength' => 36
    ]
  ];

  public string $ID;
  public string $invoiceID;
  public string $workSessionID;

  public Invoice $invoice;
  public WorkSession $workSession;
}
