<?php
/**
 * "{{catalog}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class Catalog extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{catalog}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('catalog_name', 'required'),
			array('page_size', 'numerical', 'integerOnly'=>true),
			array('parent_id, sort_order, data_count, create_time', 'length', 'max'=>10),
			array('catalog_name, catalog_name_second, catalog_name_alias, seo_title, attach_file, attach_thumb, template_list, template_page, template_show', 'length', 'max'=>100),
			array('seo_keywords, redirect_url, acl_browser, acl_operate', 'length', 'max'=>255),
			array('status_is, menu_is', 'length', 'max'=>1),
			array('display_type', 'length', 'max'=>4),
			array('content, seo_description', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, parent_id, catalog_name, catalog_name_second, catalog_name_alias, content, seo_title, seo_keywords, seo_description, attach_file, attach_thumb, sort_order, data_count, page_size, status_is, menu_is, redirect_url, display_type, template_list, template_page, template_show, acl_browser, acl_operate, create_time', 'safe', 'on'=>'search'),
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
			'parent_id' => '上级分类',
			'catalog_name' => '名称',
			'catalog_name_second' => '副名称',
			'catalog_name_alias' => '别名',
			'content' => '详细介绍',
			'seo_title' => 'seo标题',
			'seo_keywords' => 'seo关键字',
			'seo_description' => 'seo描述',
			'attach_file' => '附件',
			'attach_thumb' => '缩略图',
			'sort_order' => '排序',
			'data_count' => '数据量',
			'page_size' => '每页显示数量',
			'status_is' => '状态',
			'menu_is' => '是否导航显示',
			'redirect_url' => '跳转地址',
			'display_type' => '显示方式',
			'template_list' => '列表模板',
			'template_page' => '单页模板',
			'template_show' => '内容页模板',
			'acl_browser' => '浏览权限',
			'acl_operate' => '操作权限',
			'create_time' => '录入时间',
		);
	}


	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Catalog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    /**
     * 取分类
     */
	static public function get($parentid = 0, $array = array(), $level = 0, $add = 2, $repeat = '&nbsp;&nbsp;') {
        
        $str_repeat = '';
        if ($level) {
            for($j = 0; $j < $level; $j ++) {
                $str_repeat .= $repeat;
            }
        }
        $newarray = array ();
        $temparray = array ();
        foreach ( ( array ) $array as $v ) {
            if ($v ['parent_id'] == $parentid) {
                $newarray [] = array ('id' => $v ['id'], 'catalog_name' => $v ['catalog_name'], 'catalog_name_alias' => $v ['catalog_name_alias'], 'parent_id' => $v ['parent_id'], 'level' => $level, 'sort_order' => $v ['sort_order'], 'seo_keywords' => $v ['seo_keywords'], 'seo_description' => $v ['seo_description'], 'attach_file' => $v ['attach_file'], 'attach_thumb' => $v ['attach_thumb'], 'status_is' => $v ['status_is'], 'data_count' => $v ['data_count'] , 'display_type' => $v ['display_type'], 'menu_is' => $v ['menu_is'],'template_list' => $v ['template_list'],'acl_browser' => $v ['acl_browser'],'acl_operate' => $v ['acl_operate'],'template_page' => $v ['template_page'],'template_show' => $v ['template_show'],'create_time' => $v ['create_time'], 'str_repeat' => $str_repeat, 'page_size'=>$v['page_size'] );
    
                $temparray = self::get ( $v ['id'], $array, ($level + $add) );
                if ($temparray) {
                    $newarray = array_merge ( $newarray, $temparray );
                }
            }
        }
        return $newarray;
    }
    
    
    
    /**
     * 获取下级子类，普通模式
     *
     * @param $parentId
     * @param array $array
     * @return array
     */
    static public function lite ($parentId, array $array = array(), $params = array())
    {
        if(empty($parentId))
            return ;
        $eachArr = empty($array)? XXcache::system('_catalog', 86400): $array;
        foreach ((array)$eachArr as $row) {
            if ($row['parent_id'] == $parentId)
                $arr[] = $row;
        }
        return $arr;
    }

    /**
     * 取子类连接
     * @param $parentId
     * @param array $array
     */
    static public function subArr2str ($parentId, array $array = array(), $self = true)
    {
         if(empty($parentId))
            return ;
        $eachArr = empty($array)? XXcache::system('_catalog', 86400): $array;
        foreach ((array)$eachArr as $row) {
            if ($row['parent_id'] == $parentId)
                $arr[] = $row['id'];
        }
        $string = implode(',', $arr);
        return $self ? $string . ',' . $parentId : $string;
    
    }

    /**
     * 取分类名称
     *
     * @param $parentId
     * @param array $array
     * @return string
     */
    static public function name ($catalog, array $array = array())
    {
         if(empty($catalog))
            return ;
        $eachArr = empty($array)? XXcache::system('_catalog', 86400): $array;
        foreach ((array)$eachArr as $row) {
            if ($row['id'] == $catalog)
                $name = $row['catalog_name'];
        }
        return $name;
    }

    /**
     * 根据项目名称取类别ID
     * @param $catalog
     * @param array $array
     * @return unknown
     */
    static public function alias2idArr ($alias, array $array = array())
    {
        if(empty($alias))
            return ;
        $eachArr = empty($array)? XXcache::system('_catalog', 86400): $array;
        foreach ((array)$eachArr as $row) {
            if ($row['catalog_name_alias'] == $alias)
                return $row;
        }
    
    }

    /**
     * 取单条记录
     * @param $catalog
     * @param array $array
     */
    static public function item ($id, array $array = array())
    {
        if(empty($id))
            return ;
        $eachArr = empty($array)? XXcache::system('_catalog', 86400): $array;
        foreach ((array)$eachArr as $row) {
            if ($row['id'] == $id)
                return $row;
        }
    }

}
