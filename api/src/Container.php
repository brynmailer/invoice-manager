<?php

namespace Api;

class Container {
  public function __construct(
    $server,
    $get,
    $post,
    $cookie,
    $session,
    $config
  ) {
    $this->server = $server;
    $this->get = $get;
    $this->post = $post;
    $this->cookie = $cookie;
    $this->session = $session;
    $this->config = $config;
  }
}
