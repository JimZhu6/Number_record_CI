<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 号码标记功能实现模块
 */
class Number_record_model extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    // 启用redis类
    $this->load->driver('cache');
  }

  /**
	 * 获取号码集合总数
	 */
  public function get_count()
  {
    return $this->cache->redis->sSize('demo.cc:telephone_list');
  }

  /**
	 * 添加号码
	 */
  public function add_tel($tel)
  {
    return $this->cache->redis->sAdd('demo.cc:telephone_list', $tel);
  }

  /**
	 * 通过txt文件导入号码
	 */
  public function add_tel_from_text($arr)
  {
    return $this->cache->redis->multi_add('demo.cc:telephone_list', $arr);
  }

  /**
	 * 通过xls文件导入号码
	 */
  public function add_tel_from_xls($arr)
  {
    return $this->cache->redis->multi_add('demo.cc:telephone_list', $arr, 1);
  }

  /**
	 * 标记号码
	 */
  public function mark_tel($remarks_msg)
  {
    return $this->cache->redis->sAdd('demo.cc:marked_list', $remarks_msg);
  }

  /**
	 * 搜索号码
	 */
  public function search_tel($search_tel)
  {
    $mark_num_info = null;
    // 获取已被标记的号码
    $arr = $this->cache->redis->sMembers('demo.cc:marked_list');
    for ($i = 0; $i < count($arr); $i++) {
      list($tel, $marked_date, $marked_msg) = explode("|", $arr[$i]);
      if ($tel == $search_tel) {
        // 号码已标记
        $a['tel'] = $tel;
        $a['m_date'] = $marked_date;
        $a['m_msg'] = $marked_msg;
        $mark_num_info = $a;
      }
    }

    // 查找号码是否存在与集合中
    if ($this->cache->redis->sIsMember('demo.cc:telephone_list', $search_tel)) {
      if ($mark_num_info['tel'] == $search_tel) {
        // 已被标记
        $query['type'] = 2;
        $query['tel'] = $search_tel;
        $query['mark_date'] = $mark_num_info['m_date'];
        $query['remarks'] = $mark_num_info['m_msg'];
      } else {
        // 未被标记
        $query['type'] = 1;
        $query['tel'] = $search_tel;
      }
    } else {
      $query['type'] = 0;
      $query['msg'] = '查无数据';
    }
    return $query;
  }
}
