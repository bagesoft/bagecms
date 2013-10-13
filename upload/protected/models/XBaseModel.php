<?php
/**
 * 模型基础类，所有模型均需继承此类
 * @author shuguang <5565907@qq.com>
 */
class XBaseModel extends CActiveRecord
{
    /**
     * 检测用户密码
     *
     * @return boolean
     */
    public function validatePassword ($password)
    {
        return $this->hashPassword($this->password) === $password;
    }

    /**
     * 密码进行加密
     * @return string password
     */
    public function hashPassword ($password)
    {
        return md5($password);
    }

    /**
     * 数据保存前处理
     * @return boolean.
     */
    protected function beforeSave ()
    {
        if ($this->isNewRecord) {
            isset($this->create_time) && $this->create_time = time();
        } else {
            isset($this->last_update_time) && $this->last_update_time = time();
        }
        return true;
    }
    
}