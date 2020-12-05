<?php declare(strict_types=1);

namespace App\Middleware;

use App\Entity;

class Invoices {
  public function invoiceExists(
    $req,
    $res,
    $next
  ) {
    $invoices = Entity\Invoice::select([
      'where' => [
        'ID' => $req->getAttribute('params')['invoiceID'],
        'employerID' => $req->getAttribute('employer')->ID
      ],
    ]);

    if (\count($invoices) !== 1) return $res->withStatus(404);

    return $next(
      $req->withAttribute('invoice', $invoices[0]),
      $res
    );
  }
}
