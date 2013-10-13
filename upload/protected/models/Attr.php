<?php
/**
 * "{{attr}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class Attr extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{attr}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('attr_name', 'required'),
			array('catalog_id, max_lenght', 'numerical', 'integerOnly'=>true),
			array('scope', 'length', 'max'=>6),
			array('attr_name, attr_name_alias', 'length', 'max'=>50),
			array('tips', 'length', 'max'=>255),
			array('sort_order, create_time', 'length', 'max'=>10),
			array('attr_type', 'length', 'max'=>8),
			array('data_default', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, scope, attr_name, attr_name_alias, catalog_id, tips, sort_order, attr_type, data_default, max_lenght, create_time', 'safe', 'on'=>'search'),
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
			'scope' => '使用范围',
			'attr_name' => '字段名称',
			'attr_name_alias' => '字段别名',
			'catalog_id' => '所属栏目',
			'tips' => '说明',
			'sort_order' => '排序',
			'attr_type' => '字段类型',
			'data_default' => '字段默认数据',
			'max_lenght' => '长度',
			'create_time' => '录入时间',
		);
	}


	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Attr the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * 录入：内容关联属性
	 *
	 * @param [void]  $postId [内容编号]
	 * @param [type]  $attrData  [description]
	 * @return [type]            [description]
	 */
	public static function create( $postId, $attrData ) {

		foreach ( (array) $attrData as $key => $row ) {

			$val = is_array( $row['val'] ) ? implode( ',', $row['val'] ) : $row['val'];
			if ( $val ) {

				$attrValModel = new AttrVal();
				$attrValModel -> post_id = $postId;
				$attrValModel -> attr_id = $row['id'];
				$attrValModel -> attr_name = $row['name'];
				$attrValModel -> attr_val = $val;
				$attrValModel -> save();
			}
		}
	}

	/**
	 * 编辑：内容关联属性
	 *
	 * @param [type]  $postId [description]
	 * @param [type]  $attrData  [description]
	 * @return [type]            [description]
	 */
	public static function xupdate( $postId, $attrData ) {
		foreach ( (array) $attrData as $key => $row ) {

			$val = is_array( $row['val'] ) ? implode( ',', $row['val'] ) : $row['val'];
			if ( $val ) {
				$attrVal = AttrVal::model() -> find( 'post_id=:postId AND attr_id=:attrId', array( 'postId' => $postId, 'attrId' => $row['id'] ) );

				if ( $attrVal ) {
					$attrVal -> post_id = $postId;
					$attrVal -> attr_id = $row['id'];
					$attrVal -> attr_name = $row['name'];
					$attrVal -> attr_val = $val;
					$attrVal -> save();
				} else {
					$attrValModel = new AttrVal();
					$attrValModel -> post_id = $postId;
					$attrValModel -> attr_id = $row['id'];
					$attrValModel -> attr_name = $row['name'];
					$attrValModel -> attr_val = $val;
					$attrValModel -> save();
				}
			}
		}
	}

	/**
	 * 数据被重置
	 * @param  [type] $datas [description]
	 * @return [type]        [description]
	 */
	public static function dataReset($datas){


		foreach ((array)$datas as $key => $value) {
			if(is_array($value['val']))
				$var[$value['name']] = implode(',', $value['val']);
			else
				$var[$value['name']] = $value['val'];
			
		}

		return $var;

	}

	/**
	 * 属性列表
	 * @param  integer $catalog [description]
	 * @param  string  $scope   [description]
	 * @return [type]           [description]
	 */
	public static function lists( $catalog = 0, $scope = 'post' ) {
		$model = new Attr();

		if($catalog){
			$attrModel = $model ->findAll( array( 'condition'=>'scope=:scope AND catalog_id=:catalogId', 'params'=>array( 'scope'=>$scope, 'catalogId'=>$catalog ), 'order'=>'sort_order DESC,id DESC' ) );
		}else{
			$attrModel = $model ->findAll( array( 'condition'=>'scope=:scope ', 'params'=>array( 'scope'=>$scope), 'order'=>'sort_order DESC,id DESC' ) );
		}
		foreach ( (array)$attrModel as $key=>$row ) {
			$data[$key] = self::_attr2val( $row );
		}

		return $data;

	}

	/**
	 * 获取属性数据
	 * @param  integer $postId [description]
	 * @return [type]             [description]
	 */
	public static function datas($postId =0 ){

		$attrDataModel = AttrVal::model()->findAll('post_id=:postId', array('postId'=>$postId));

		foreach ($attrDataModel as $key => $value) {
			$data[$value['attr_name']] = $value['attr_val'];
		}

		return $data;

	}

	/**
	 * 清空内容属性数据
	 * @param  [type] $attrId [description]
	 * @return [type]         [description]
	 */
	public static function clear($var){
		if($var['oldScope'] == 'post'){
			AttrVal::model()->deleteAll('attr_id=:attrId',array('attrId'=>$var['attrId']));
		}elseif($var['oldScope'] == 'config'){
			Config::model()->deleteAll('variable=:variable',array('variable'=>'_'.$var['attrName']));
		}elseif ($var['oldScope'] == 'all') {
			AttrVal::model()->deleteAll('attr_id=:attrId',array('attrId'=>$var['attrId']));
			Config::model()->deleteAll('variable=:variable',array('variable'=>'_'.$var['attrName']));
		}
	}

	/**
	 * 还原属性数据
	 *
	 * @param [type]  $row [description]
	 * @return [type]      [description]
	 */
	private function _attr2val( $row ) {

		$attributes = $row->attributeNames();

		foreach ( $attributes as $key=>$val ) {
			$d[$val] = $row->$val;
		}

		return $d;
	}
}
