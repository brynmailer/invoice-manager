<?php declare(strict_types=1);

namespace App\Middleware;

class RateLimit {
  public function fixedWindowDay(
    $req,
    $res,
    $next
  ) {
    if (!isset($_SESSION['window'])) $_SESSION['window'] = [
      'start' => time(),
      'count' => 0
    ];

    $_SESSION['window']['count']++;

    if (time() > $_SESSION['window']['start'] + REQUESTS_PER_WINDOW) {
      $_SESSION['window'] = [
        'start' => time(),
        'count' => 1
      ];
    } else if ($_SESSION['window']['count'] > RATELIMIT_WINDOW) {
      return $res->withStatus(429);
    }

    return $next(
      $req,
      $res
    );
  }

  public function fixedWindowSec(
    $req,
    $res,
    $next
  ) {
    if (time() === $_SESSION['lastRequest']) {
      return $res->withStatus(429);
    }

    $_SESSION['lastRequest'] = time();

    return $next(
      $req,
      $res
    );
  }
}
