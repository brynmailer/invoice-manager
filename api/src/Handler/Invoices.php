<?php declare(strict_types=1);

namespace App\Handler;

use App\Entity;

class Invoices {
  public function getInvoices(
    $req,
    $res,
    $next
  ) {
    $invoices = Entity\Invoice::select([
      'where' => [
        'employerID' => $req->getAttribute('employer')->ID
      ]
    ]);

    $invoices = \array_map(function ($invoice) {
      $invoiceItems = Entity\InvoiceItem::select([
        'where' => [
          'invoiceID' => $invoice->ID
        ],
        'expand' => [
          'workSession' => [
            'project',
            'employee' => [
              'user'
            ]
          ]
        ]
      ]);

      $invoice->items = $invoiceItems;

      return $invoice;
    }, $invoices);

    return $res
      ->withStatus(200)
      ->withPayload($invoices);
  }

  public function getInvoice(
    $req,
    $res,
    $next
  ) {
    $invoice = $req->getAttribute('invoice');

    $invoice->items = Entity\InvoiceItem::select([
      'where' => [
        'invoiceID' => $invoice->ID
      ],
      'expand' => [
        'workSession' => [
          'project',
          'employee' => [
            'user'
          ]
        ]
      ]
    ]);

    return $res
      ->withStatus(200)
      ->withPayload($invoice);
  }

  public function createInvoice(
    $req,
    $res,
    $next
  ) {
    $invoice = new Entity\Invoice([
      'employerID' => $req->getAttribute('employer')->ID
    ]);

    $invoice = $invoice->save();

    $invoiceItems = \array_map(function ($workSessionID) use (&$invoice) {
      $invoiceItem = new Entity\InvoiceItem([
        'invoiceID' => $invoice->ID,
        'workSessionID' => $workSessionID
      ]);

      return $invoiceItem->save();
    }, $req->getParsedBody()['workSessionIDs']);

    $invoice->items = $invoiceItems;

    return $res
      ->withStatus(201)
      ->withPayload($invoice);
  }

  public function editInvoice(
    $req,
    $res,
    $next
  ) {
    $invoice = $req->getAttribute('invoice');

    $oldInvoiceItems = Entity\InvoiceItem::select([
      'where' => [
        'invoiceID' => $invoice->ID
      ]
    ]);

    $invoice->updated = $req->getParsedBody()['updated'] ?? null;

    $invoice->save();

    foreach ($oldInvoiceItems as &$oldInvoiceItem) {
      if (!\in_array($oldInvoiceItem->workSessionID, $req->getParsedBody()['workSessionIDs'])) {
        Entity\InvoiceItem::delete([
          'where' => [
            'ID' => $oldInvoiceItem->ID
          ]
        ]);
      }
    }

    $invoiceItems = \array_map(function ($workSessionID) use (&$invoice) {
      $invoiceItem = Entity\InvoiceItem::select([
        'where' => [
          'invoiceID' => $invoice->ID,
          'workSessionID' => $workSessionID
        ]
      ]);

      if (\count($invoiceItem) < 1) {
        $invoiceItem = new Entity\InvoiceItem([
          'invoiceID' => $invoice->ID,
          'workSessionID' => $workSessionID
        ]);
        
        return $invoiceItem->save();
      };

      return $invoiceItem[0];
    }, $req->getParsedBody()['workSessionIDs']);

    $invoice->items = $invoiceItems;

    return $res
      ->withStatus(200)
      ->withPayload($invoice);
  }

  public function deleteInvoice(
    $req,
    $res,
    $next
  ) {
    Entity\InvoiceItem::delete([
      'where' => [
        'invoiceID' => $req->getAttribute('params')['invoiceID']
      ]
    ]);

    Entity\Invoice::delete([
      'where' => [
        'ID' => $req->getAttribute('params')['invoiceID'],
        'employerID' => $req->getAttribute('employer')->ID
      ]
    ]);

    return $res->withStatus(204);
  }
}
