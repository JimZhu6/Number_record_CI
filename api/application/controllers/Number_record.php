<?php
defined('BASEPATH') or exit('No direct script access allowed');

// xls文件阅读器
use PhpOffice\PhpSpreadsheet\IOFactory;

class Number_record extends CI_Controller
{
  public function __construct()
  {
    parent::__construct();
    // 加载模块
    $this->load->model('Number_record_model', 'NRM');
  }

  /**
	 * 处理输出
	 */
  private function _ajax_output($data)
  {
    $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode($data));
  }

  /**
	 * 检测是否登录逻辑
	 */
  public function test_login()
  {
    // 判断是否具有已登录的session信息
    if (isset($_SESSION['username'])) {
      $res['code'] = 200;
      $res['msg']['username'] = $_SESSION['username'];
    } else {
      $res['code'] = 204;
    }
    $this->_ajax_output($res);
  }

  /**
	 * 登录逻辑
	 */
  public function login()
  {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    // 加载模块
    $this->load->model('Login_authentication_model');
    // 执行模块里登录函数
    $query = $this->Login_authentication_model->login();

    if (
      $query['username'] == $username &&
      $query['password'] == $password
    ) {
      // 使用session类设置指定键值对
      $this->session->set_userdata('username', $username);
      $res['code'] = 200;
      $res['msg']['text'] = "登录成功";
      $res['msg']['username'] = $username;
    } else {
      $res['code'] = 204;
      $res['msg']['text'] = "登录失败";
    }

    $this->_ajax_output($res);
  }

  /**
	 * 获取数据总量
	 */
  public function get_count()
  {
    $query = $this->NRM->get_count();
    $res['code'] = 200;
    $res['data'] = $query;

    $this->_ajax_output($res);
  }

  /**
	 * 添加号码
	 */
  public function add_tel($tel)
  {
    $query = $this->NRM->add_tel($tel);
    if ($query) {
      $res['code'] = 200;
      $res['msg'] = '添加成功';
    } else {
      $res['code'] = 204;
      $res['msg'] = '添加失败，数据已存在';
    }

    $this->_ajax_output($res);
  }

  /**
	 * 通过txt导入号码
	 */
  public function add_tel_from_txt()
  {
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {
      // 处理文件
      $root_dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";
      $filename = $_FILES['file']['name'];
      $filename = time() . "_$filename";
      $uploadFile = $root_dir . $filename;
      if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        // 将文件存在指定目录
        $line = count(file($uploadFile));
        if ($line > 50000) {
          $res['code'] = 200;
          $res['msg'] = "操作失败！一次只能添加五万条数据";
        } else {
          // 读文件
          $file = fopen($uploadFile, 'r');
          $arr = array();
          $j = 0;
          while (!feof($file)) {
            $a = mb_convert_encoding(fgets($file), "UTF-8", "GBK,ASCII,ANSI,UTF-8");
            $arr[$j] = trim($a);
            $j++;
          }
          fclose($file);
          // 将读取到的数据数组交给模块操作
          $query = $this->NRM->add_tel_from_text($arr);
          if ($query) {
            $res['code'] = 200;
            $res['msg'] = "成功导入 $line 条数据";
          } else {
            $res['code'] = 204;
            $res['msg'] = '上传失败';
          }
        }
      }
    }

    $this->_ajax_output($res);
  }

  /**
	 * 通过xls文件导入号码
	 */
  public function add_tel_from_xls()
  {
    if (is_uploaded_file($_FILES['file']['tmp_name'])) {
      // 处理文件
      $root_dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/";
      $filename = $_FILES['file']['name'];
      $filename = time() . "_$filename";
      $uploadFile = $root_dir . $filename;
      if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
        $reader = IOFactory::createReader("Xls");
        $spreadsheet = $reader->load($uploadFile);
        // 获取数据
        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
        // 将文件存在指定目录
        $line = count($sheetData);
        if ($line > 50000) {
          $res['code'] = 200;
          $res['msg'] = "操作失败！一次只能添加五万条数据";
        } else {
          $arr = array();
          for ($i = 1; $i < $line; $i++) {
            $arr[$i] = $sheetData[$i]['A'];
          }
          // 将读取到的数据数组交给模块操作
          $query = $this->NRM->add_tel_from_xls($arr);
          if ($query) {
            $res['code'] = 200;
            $res['msg'] = "成功导入 $line 条数据";
          } else {
            $res['code'] = 204;
            $res['msg'] = '上传失败';
          }
        }
      }
    }

    $this->_ajax_output($res);
  }

  /**
	 * 标记号码
	 */
  public function mark_tel()
  {
    $tel = $this->input->post('remarksTel');
    $remarks = $this->input->post('remarksMsg');
    $time = time() * 1000;
    $query = $this->NRM->mark_tel("$tel|$time|$remarks");
    if ($query) {
      $res['code'] = 200;
      $res['data']['msg'] = '标记成功';
      $res['data']['list']['mark_date'] = $time;
      $res['data']['list']['remarks'] = $remarks;
    } else {
      $res['code'] = 200;
      $res['data']['msg'] = '标记失败';
    }

    $this->_ajax_output($res);
  }

  /**
	 * 搜索号码
	 */
  public function search_tel($tel)
  {
    $query = $this->NRM->search_tel($tel);
    $res['code'] = 200;
    $res['data'] = $query;
    $this->_ajax_output($res);
  }
}
