<?php

require_once "config.php";

class Redis_class
{
  public function r_init()
  {
    $r = new Redis();
    $r->connect(RD_HOST, RD_PORT);
    return $r;
  }
}
