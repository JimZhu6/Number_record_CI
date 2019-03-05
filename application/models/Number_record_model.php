<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 * 号码标记功能实现模块
 */
class Number_record_model extends CI_Model
{

  private function _init()
  {
    $CI = &get_instance();
    // 引入redis资源
    $CI->load->library('Redis_class');
    $r = $CI->redis_class->r_init();
    return $r;
  }

  /**
	 * 获取号码集合总数
	 */
  public function get_count()
  {
    $r = $this->_init();
    // 查询集合元素总数
    return $r->sSize('demo.cc:telephone_list');
  }

  /**
	 * 添加号码
	 */
  public function add_tel($tel)
  {
    $r = $this->_init();
    // 集合增加元素
    return $r->sAdd('demo.cc:telephone_list', $tel);
  }

  /**
	 * 通过txt文件导入号码
	 */
  public function add_tel_from_text($arr)
  {
    $r = $this->_init();
    // 部署事务
    $r->multi();
    for ($i = 0; $i < count($arr); $i++) {
      $r->sAdd('demo.cc:telephone_list', $arr[$i]);
    }
    $r->exec();
    return $r;
  }

  /**
	 * 通过xls文件导入号码
	 */
  public function add_tel_from_xls($arr)
  {
    $r = $this->_init();
    // 部署事务
    $r->multi();
    for ($i = 1; $i < count($arr); $i++) {
      $r->sAdd('demo.cc:telephone_list', $arr[$i]);
    }
    $r->exec();
    return $r;
  }

  /**
	 * 标记号码
	 */
  public function mark_tel($remarks_msg)
  {
    $r = $this->_init();
    return $r->sAdd('demo.cc:marked_list', $remarks_msg);
  }

  /**
	 * 搜索号码
	 */
  public function search_tel($search_tel)
  {
    $r = $this->_init();
    $mark_num_info = null;
    // 获取已被标记的号码
    $arr = $r->sMembers('demo.cc:marked_list');
    for ($i = 0; $i < count($arr); $i++) {
      list($tel, $marked_date, $marked_msg) = explode("|", $arr[$i]);
      if ($tel == $search_tel) {
        // 号码已标记
        $temp = [
          'tel' => $tel,
          'm_date' => $marked_date,
          'm_msg' => $marked_msg
        ];
        $mark_num_info = $temp;
      }
    }

    // 查找号码是否存在与集合中
    if ($r->sIsMember('demo.cc:telephone_list', $search_tel)) {
      if ($mark_num_info['tel'] == $search_tel) {
        // 已被标记
        $query = [
          'type' => 2,
          'tel' => $search_tel,
          'mark_date' => $mark_num_info['m_date'],
          'remarks' => $mark_num_info['m_msg']
        ];
      } else {
        // 未被标记
        $query = [
          'type' => 1,
          'tel' => $search_tel
        ];
      }
    } else {
      $query = [
        'type' => 0,
        'msg' => "查无数据"
      ];
    }
    return $query;
  }
}
