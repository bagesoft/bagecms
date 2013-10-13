<?php
/**
 * "{{link}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class Link extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{link}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('site_name, site_url', 'required'),
			array('site_name, attach_file', 'length', 'max'=>100),
			array('site_url', 'length', 'max'=>255),
			array('sort_order, click_count, create_time', 'length', 'max'=>10),
			array('link_type', 'length', 'max'=>5),
			array('status_is', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, site_name, site_url, sort_order, click_count, link_type, attach_file, status_is, create_time', 'safe', 'on'=>'search'),
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
			'site_name' => '名称',
			'site_url' => '链接地址',
			'sort_order' => '排序',
			'click_count' => '点击次数',
			'link_type' => '链接类型',
			'attach_file' => '链接图片',
			'status_is' => '显示状态',
			'create_time' => '录入时间',
		);
	}


	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Link the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 自动化初始值/处理数据
	 *
	 * @return unknown
	 */
	public function beforeSave()
	{
	    if($this->isNewRecord){
	        isset($this->create_time)&& $this->create_time = time();
	    }
	    $this->sort_order = intval($this->sort_order);
	    $this->site_url = XUtils::convertHttp($this->site_url);
	    return true;
	}
}
