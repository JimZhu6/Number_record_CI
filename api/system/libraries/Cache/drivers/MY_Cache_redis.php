<?php
/**
 * 扩展redis类库
 */
class MY_Cache_redis extends CI_Cache_redis
{
  public function __construct()
  {
    parent::__construct();
  }

  /**
	 * 获取指定`key`里的`hash`对象
	 *
	 * @param string $key keyName
	 * @return array `hash`对象
	 */
  public function hMGetAll($key)
  {
    return $this->_redis->hGetAll($key);
  }

  /**
	 * 获取指定`key`里集合元素的数量
	 *
	 * @param keyName
	 * @return number
	 */
  public function sSize($key)
  {
    return $this->_redis->sSize($key);
  }

  /**
	 * 将元素添加到指定`key`的集合中
	 * 
	 * @param keyName
	 * @param value
	 * @return number
	 */
  public function sAdd($key, $value)
  {
    return $this->_redis->sAdd($key, $value);
  }

  /**
	 * 获取指定集合`key`里的所有元素
	 * 
	 * @param keyName
	 * @return array
	 */
  public function sMembers($key)
  {
    return $this->_redis->sMembers($key);
  }

  /**
	 * 检测指定元素是否存在于指定集合`key`中
	 * 
	 * @param keyName
	 * @param element
	 * @return boolean
	 */
  public function sIsMember($key, $element)
  {
    return $this->_redis->sIsMember($key, $element);
  }

  /**
	 * 事务-集合增加元素
	 */
  public function multi_add($key, $valueArr, $start = 0)
  {
    $temp_redis = $this->_redis;
    $ret = $temp_redis->multi();
    for ($i = $start; $i < count($valueArr); $i++) {
      $ret->sAdd($key, $valueArr[$i]);
    }
    $ret->exec();
    return $ret;
  }
}
