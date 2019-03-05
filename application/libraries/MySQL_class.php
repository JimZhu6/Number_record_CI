<?php

require_once "config.php";

class MySQL_class
{
  public function sql_init()
  {
    $m = new mysqli(SQL_HOST, SQL_USERNAME, SQL_PASSWORD, SQL_DBNAME, SQL_PORT);
    $m->set_charset(SQL_DB_CHARSET);
    return $m;
  }
}
