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

    if (time() > $_SESSION['window']['start'] + RATELIMIT_WINDOW) {
      $_SESSION['window'] = [
        'start' => time(),
        'count' => 1
      ];
    } else if ($_SESSION['window']['count'] > REQUESTS_PER_WINDOW) {
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
    // Checks if current time to the nearest second is the same as the last requests time to the nearest second
    // if so, denies the request.
    
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
