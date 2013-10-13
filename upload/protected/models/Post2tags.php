<?php
/**
 * "{{post_2tags}}" 数据表模型类.
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Model
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class Post2tags extends XBaseModel
{
	
	/**
	 * @return string 相关的数据库表的名称
	 */
	public function tableName()
	{
		return '{{post_2tags}}';
	}

	/**
	 * @return array 对模型的属性验证规则.
	 */
	public function rules()
	{
		return array(
			array('tag_name', 'required'),
			array('title_id', 'length', 'max'=>10),
			array('tag_name', 'length', 'max'=>30),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title_id, tag_name', 'safe', 'on'=>'search'),
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
	        'post'=>array(self::BELONGS_TO, 'Post', 'title_id', 'alias'=>'post', 'select'=>'id,title,view_count,create_time'),
	    );
	}

	/**
	 * @return array 自定义属性标签 (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title_id' => '标题ID',
			'tag_name' => '标签名称',
		);
	}


	/**
	 * 返回指定的AR类的静态模型.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Post2tags the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
     * tags 操作
     *
     * @param $method
     * @param $tags
     * @param $titleId
     * @param $model
     * @param $jumpUri
     */
    static public function build ($method = 'create', $tags = '', $title_id = 0, $catalog_id = 0, $redirect = '')
    {
        if (! empty($tags)) {
            if ($method == 'create') {
                self::_tagsCreate($tags, $title_id, $catalog_id, $redirect);
            } elseif ($method == 'update') {
                self::_tagsUpdate($tags, $title_id, $catalog_id, $redirect);
            }
        }
    
    }

    /**
     * tags 写入操作 parent:tags
     *
     * @param $tags
     * @param $titleId
     * @param $model
     * @param $jumpUri
     */
    protected function _tagsCreate ($tags = '', $title_id = 0, $catalog_id = 0, $redirect)
    {
        $tags_array = array_unique(explode(',', str_replace(array (' ' , '，' ), ',', $tags)));
        $tagCount = 0;
        foreach ($tags_array as $tag_name) {
            $tagCount ++;
            if ($tagCount >= 10) {
                unset($tags_array);
                break;
            }
            $dao = new PostTags();
            $get_data = $dao->find('tag_name=:tag_name', array ('tag_name' => $tag_name ));
            if (empty($get_data)) {
                $dao->catalog_id = $catalog_id;
                $dao->data_count = 1;
                $dao->tag_name = $tag_name;
                $dao->create_time = time();
                $id = $dao->save();
            } else {
                $get_data->data_count = $get_data->data_count + 1;
                $get_data->save();
            }
            //写入关联
            self::_tagsRelation($tag_name, $title_id);
        
        }
    
    }

    /**
     * tags 更新操作 parent:tags
     *
     * @param $tags
     * @param $titleId
     * @param $model
     * @param $jumpUri
     */
    protected function _tagsUpdate ($tags = '', $title_id = 0, $catalog_id = 0, $redirect)
    {
        $tagsRelation = new Post2tags();
        
        $tagsRelationArray = $tagsRelation->findAll('title_id=:title_id', array ('title_id' => $title_id ));
        $tagsArray = array ();
        foreach ((array) $tagsRelationArray as $row) {
            $tagsArray[] = $row['tag_name'];
        }
        $titleTags = implode(',', $tagsArray);
        $explodeTags = array_unique(explode(',', str_replace(array (' ' , '，' ), ',', $tags)));
        $tagCount = 0;
        foreach ((array) $explodeTags as $value) {
            $tagCount ++;
            if ($tagCount >= 10) {
                unset($explodeTags);
                break;
            }
            
            $TagsArrayNew[] = $value;
            if (! in_array($value, $tagsArray)) {
                $dao = new PostTags();
                $get_data = $dao->find('tag_name=:tag_name', array ('tag_name' => $value ));
                
                if (empty($get_data)) {
                    $dao->catalog_id = $catalog_id;
                    $dao->data_count = 1;
                    $dao->tag_name = $value;
                    $dao->create_time = time();
                    $id = $dao->save();
                
                } else {
                    $get_data->data_count = $get_data->data_count + 1;
                    $get_data->save();
                }
                //写入关联
                self::_tagsRelation($value, $title_id);
            }
        }
        
        foreach ($tagsArray as $tagName) {
            if (! in_array($tagName, $TagsArrayNew)) {
                $getTagsCount = Post2tags::model()->count('title_id!=:title_id AND tag_name=:tag_name', array ('title_id' => $title_id , 'tag_name' => $tagName ));
                if ($getTagsCount) {
                    Yii::app()->db->createCommand("UPDATE {{news_tags}} SET data_count=data_count+1 WHERE tag_name='$tagName'")->execute();
                } else {
                    PostTags::model()->deleteAll('tag_name=:tag_name', array ('tag_name' => $tagName ));
                }
                Post2tags::model()->deleteAll('tag_name=:tag_name AND title_id=:title_id', array ('tag_name' => $tagName , 'title_id' => $title_id ));
            }
        }
    }

    /**
     * tags 关联主题ID
     *
     * @param $tags
     * @param $title_id
     * @param $model
     */
    protected function _tagsRelation ($tags = '', $title_id = 0)
    {
        $dao = new Post2tags();
        $dao->title_id = $title_id;
        $dao->tag_name = $tags;
        $dao->save();
    }

    /**
     * 内容连带tags删除
     *
     * @param $ids
     * @param $model
     */
    static function Xdelete ($ids = '0')
    {
        
        $id = @explode(',', $ids);
        //删除关联
        foreach ($id as $row) {
            Post2tags::model()->deleteAll('title_id=:title_id', array ('title_id' => $row ));
        }
    }
}
