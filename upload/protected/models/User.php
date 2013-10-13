<?php
/**
 * "{{user}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class User extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{user}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('username, password, captcha', 'required', 'on'=>'login'),
			array('username, email, password,captcha', 'required', 'on'=>'create'),
		    array('username', 'unique', 'on'=>'create'),
		    array('email', 'email'),
			array('captcha', 'captcha', 'allowEmpty'=>!extension_loaded('gd'), 'on'=>'login,create'),
			array('group_id', 'numerical', 'integerOnly'=>true),
			array('username, city, area', 'length', 'max'=>50),
			array('email', 'length', 'max'=>60),
			array('password, hash_string', 'length', 'max'=>32),
			array('realname, brithday, province, post_code, login_count, last_login_time, last_update_time, create_time', 'length', 'max'=>10),
			array('msn, portrait, portrait_thumb', 'length', 'max'=>100),
			array('qq, telephone, mobile, register_ip, last_login_ip', 'length', 'max'=>15),
			array('sex', 'length', 'max'=>3),
			array('http_url, address', 'length', 'max'=>255),
			array('status_is', 'length', 'max'=>6),
			array('intro', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, email, password, realname, msn, qq, brithday, sex, group_id, portrait, portrait_thumb, province, city, area, http_url, telephone, mobile, post_code, address, intro, hash_string, status_is, register_ip, login_count, last_login_time, last_login_ip, last_update_time, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'userGroup'=>array(self::BELONGS_TO, 'UserGroup', 'id', 'foreignKey'=>'group_id', 'alias'=>'group', 'select'=>'id,group_name'),
        );
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => '用户id',
			'username' => '用户名',
			'email' => '邮箱',
			'password' => '密码',
			'realname' => '真实姓名',
			'msn' => 'msn',
			'qq' => 'qq',
			'brithday' => '生日',
			'sex' => '性别',
			'group_id' => '用户组',
			'portrait' => '头像',
			'portrait_thumb' => '头像小图',
			'province' => '省',
			'city' => '市',
			'area' => '区',
			'http_url' => '网址',
			'telephone' => '电话',
			'mobile' => '手机号',
			'post_code' => '邮编',
			'address' => '地址',
			'intro' => '个人简介',
			'hash_string' => '用户验证',
			'status_is' => '用户状态',
			'register_ip' => '注册ip',
			'login_count' => '登录次数',
			'last_login_time' => '最后登录时间',
			'last_login_ip' => '最后登录IP',
			'last_update_time' => '最后更新时间',
			'create_time' => '注册时间',
		);
	}


	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 检测用户密码
	 * @param  [type] $password [description]
	 * @return [type]           [description]
	 */
	public function validatePassword($password){
		return true;
	}
}
