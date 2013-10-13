<?php
/**
 * "{{config}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class Config extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{config}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('variable', 'required'),
			array('scope', 'length', 'max'=>20),
			array('variable', 'length', 'max'=>50),
			array('description', 'length', 'max'=>255),
			array('value', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('scope, variable, value, description', 'safe', 'on'=>'search'),
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
			'scope' => '范围',
			'variable' => '变量',
			'value' => '值',
			'description' => '描述',
		);
	}

	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Config the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
     * 获取配置信息
     * @param  string $var   [description]
     * @param  string $scope [description]
     * @return [type]        [description]
     */
    public static function get ($var = '', $scope = 'base')
    {
        $condition = array ('condition' => 'scope=:scope' , 'params' => array ('scope' => $scope ) );
        $model = Config::model()->findAll($condition);
        foreach ($model as $key => $row) {
            if ($var && $var == $row['variable']) {
                return $row['value'];
            } else {
                $config[$row['variable']] = $row['value'];
            }
        
        }
        return $config;
    
    }

    /**
     * 更新配置信息
     * @param unknown_type $scope
     * @param unknown_type $variable
     * @param unknown_type $value
     */
    public static function updateVar ( $var , $value = "", $scope)
    {
        $variable = $var["variable"];
        $value = $var["value"];
        $connection = Yii::app()->db->createCommand("REPLACE INTO {{config}}(`scope`, `variable`, `value`) VALUES('$scope','$variable', '$value') ")->execute();
    }

	
}
