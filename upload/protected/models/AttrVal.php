<?php
/**
 * "{{attr_val}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class AttrVal extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{attr_val}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('post_id, attr_id', 'length', 'max'=>10),
			array('attr_name', 'length', 'max'=>60),
			array('attr_val', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('val_id, post_id, attr_id, attr_name, attr_val', 'safe', 'on'=>'search'),
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
	        'attr'=>array(self::BELONGS_TO, 'Attr', 'attr_id', 'select'=>'id,attr_name'),
	    );
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'val_id' => 'Val',
			'post_id' => '内容编号',
			'attr_id' => '属性编号',
			'attr_name' => '属性名称',
			'attr_val' => '属性内容',
		);
	}


	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AttrVal the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
}
