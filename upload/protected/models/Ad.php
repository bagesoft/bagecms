<?php
/**
 * "{{ad}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class Ad extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{ad}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>50),
			array('title_alias', 'length', 'max'=>40),
			array('link_url, image_url', 'length', 'max'=>255),
			array('width, height, click_count, start_time, expired_time, sort_order, create_time', 'length', 'max'=>10),
			array('attach_file', 'length', 'max'=>100),
			array('status_is', 'length', 'max'=>1),
			array('intro', 'safe'),
			array('id, title, title_alias, link_url, image_url, width, height, intro, click_count, start_time, expired_time, attach_file, sort_order, status_is, create_time', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array 关联规则.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'id',
			'title' => '广告名称',
			'title_alias' => '标识',
			'link_url' => '链接地址',
			'image_url' => '图片地址',
			'width' => '图片宽',
			'height' => '图片高',
			'intro' => '广告描述',
			'click_count' => '点击数',
			'start_time' => '开始时间',
			'expired_time' => '过期时间',
			'attach_file' => '附件',
			'sort_order' => '排序',
			'status_is' => '状态',
			'create_time' => '录入时间',
		);
	}

	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Ad the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
