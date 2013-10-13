<?php
/**
 * "{{page}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class Page extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{page}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('title, title_alias, content', 'required'),
			array('sort_order', 'numerical', 'integerOnly'=>true),
			array('title, title_second, html_path, html_file', 'length', 'max'=>100),
			array('title_alias', 'length', 'max'=>40),
			array('seo_title, seo_keywords', 'length', 'max'=>255),
			array('template', 'length', 'max'=>30),
			array('attach_file, attach_thumb', 'length', 'max'=>60),
			array('view_count, create_time', 'length', 'max'=>10),
			array('status_is', 'length', 'max'=>1),
			array('intro, seo_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, title_second, title_alias, html_path, html_file, intro, content, seo_title, seo_keywords, seo_description, template, attach_file, attach_thumb, sort_order, view_count, status_is, create_time', 'safe', 'on'=>'search'),
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
			'title_second' => '副标题',
			'title_alias' => '标签',
			'html_path' => 'html路径',
			'html_file' => 'html文件',
			'intro' => '简单描述',
			'content' => '内容',
			'seo_title' => 'SEO标题',
			'seo_keywords' => 'SEO KEYWORDS',
			'seo_description' => 'SEO DESCRIPTION',
			'template' => '模板',
			'attach_file' => '附件',
			'attach_thumb' => '附件小图',
			'sort_order' => '排序',
			'view_count' => '查看次数',
			'status_is' => '状态',
			'create_time' => '时间',
		);
	}


	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Page the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
