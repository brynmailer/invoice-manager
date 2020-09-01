<?php declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use InvMan\Core\Server\Router;

$router = new Router();

$router
  ->route('/invoice-manager/api/invoices/:invoiceID')
  ->get([
    function ($req, $res, $next) {
      return $res
        ->withStatus(200)
        ->withPayload([
          'invoice' => $req->getAttribute('params')['invoiceID']
        ]);
    }
  ]);

$router->emit();
