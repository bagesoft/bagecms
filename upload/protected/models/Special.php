<?php
/**
 * "{{special}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class Special extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{special}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('title, title_alias, attach_thumb, attach_file, seo_title, seo_keywords, seo_description', 'length', 'max'=>255),
			array('template', 'length', 'max'=>50),
			array('status_is', 'length', 'max'=>1),
			array('sort_order, view_count, create_time', 'length', 'max'=>10),
			array('intro, content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, title_alias, intro, content, attach_thumb, attach_file, seo_title, seo_keywords, seo_description, template, status_is, sort_order, view_count, create_time', 'safe', 'on'=>'search'),
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
			'title' => '标题',
			'title_alias' => '标题别名',
			'intro' => '描述',
			'content' => '详细介绍',
			'attach_thumb' => '附件缩略图',
			'attach_file' => '附件名称',
			'seo_title' => 'seo标题',
			'seo_keywords' => 'seo关键字',
			'seo_description' => 'seo描述',
			'template' => '模板',
			'status_is' => '状态',
			'sort_order' => '排序',
			'view_count' => '点击次数',
			'create_time' => '入库时间',
		);
	}


	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Special the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
