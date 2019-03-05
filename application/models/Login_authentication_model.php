<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 登录模块
 */
class Login_authentication_model extends CI_Model
{

  private function _init()
  {
    $CI = &get_instance();
    // 引入sql资源
    $CI->load->library('MySQL_class');
    $sql = $CI->mysql_class->sql_init();
    return $sql;
  }

  /**
	 * 登录
	 */
  public function login($username, $password)
  {
    $sql = $this->_init();

    $sqlQuery = $sql->query("SELECT password,is_active FROM user_list WHERE user_name = \"" . $username . "\"");
    $sqlResArr = $sqlQuery->fetch_assoc();

    if (
      $sqlResArr &&
      $password == $sqlResArr['password'] &&
      $sqlResArr['is_active'] == 1
    ) {
      return true;
    } else {
      return false;
    }
  }
}
