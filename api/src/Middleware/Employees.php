<?php declare(strict_types=1);

namespace App\Middleware;

use App\Entity;

class Employees {
  public function employeeExists(
    $req,
    $res,
    $next
  ) {
    $employees = Entity\Employee::select([
      'where' => [
        'ID' => $req->getAttribute('params')['employeeID'],
        'employerID' => $req->getAttribute('employer')->ID
      ]
    ]);

    if (\count($employees) !== 1) return $res->withStatus(404);

    return $next(
      $req->withAttribute('employee', $employees[0]),
      $res
    );
  }
}
