<?php
/**
 * "{{question}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class Question extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{question}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('question,realname', 'required'),
			array('scope', 'numerical', 'integerOnly'=>true),
			array('user_id, create_time', 'length', 'max'=>10),
			array('username, contact_other', 'length', 'max'=>100),
			array('realname', 'length', 'max'=>50),
			array('email', 'length', 'max'=>60),
			array('telephone', 'length', 'max'=>20),
			array('answer_status, status_is', 'length', 'max'=>1),
			array('answer_content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, scope, username, realname, email, telephone, question, contact_other, answer_status, answer_content, status_is, create_time', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => '用户',
			'scope' => '所属分类',
			'username' => '用户名',
			'realname' => '真实姓名',
			'email' => '邮箱',
			'telephone' => '电话',
			'question' => '内容',
			'contact_other' => '其它联系方式',
			'answer_status' => '回复状态',
			'answer_content' => '回复内容',
			'status_is' => '状态',
			'create_time' => '发送时间',
		);
	}


	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Question the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
