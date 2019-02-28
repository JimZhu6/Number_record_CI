<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 登录模块
 */
class Login_authentication_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    // 启用redis类
    $this->load->driver('cache');
  }


  /**
	 * 登录
	 */
  public function login()
  {
    return $this->cache->redis->hMGetAll('demo.cc:login_list');
  }
}
