<?php
/**
 * 内容管理
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class PostController extends XAdminiBase
{
    /**
     * 首页
     *
     */
    public function actionIndex() {

        parent::_acl();
        $model = new Post();
        $criteria = new CDbCriteria();
        $condition = '1';
        $title = trim( $this->_gets->getParam( 'title' ) );
        $titleAlias = trim( $this->_gets->getParam( 'titleAlias' ) );
        $catalogId = intval( $this->_gets->getParam( 'catalogId' ) );
        $title && $condition .= ' AND title LIKE \'%' . $title . '%\'';
        $titleAlias && $condition .= ' AND title_alias LIKE \'%' . $titleAlias . '%\'';
        $catalogId && $condition .= ' AND catalog_id= ' . $catalogId;
        $criteria->condition = $condition;
        $criteria->order = 't.id DESC';
        $criteria->with = array ( 'catalog' );
        $count = $model->count( $criteria );
        $pages = new CPagination( $count );
        $pages->pageSize = 13;
        $pageParams = XUtils::buildCondition( $_GET, array ( 'title' , 'catalogId','titleAlias' ) );
        $pages->params = is_array( $pageParams ) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll( $criteria );
        $this->render( 'index', array ( 'datalist' => $result , 'pagebar' => $pages ) );
    }

    /**
     * 录入
     *
     */
    public function actionCreate() {
        parent::_acl();
        $model = new Post();
        $attr = $this->_gets->getPost( 'attr' );
        $imageList = $this->_gets->getPost( 'imageList' );
        $imageListSerialize = XUtils::imageListSerialize($imageList);
      
        if ( isset( $_POST['Post'] ) ) {
            $style = $this->_gets->getPost( 'style' );
            $acl = $this->_gets->getPost( 'acl' );
            $styleFormat = XUtils::titleStyle( $style );
            $file = XUpload::upload( $_FILES['attach'], array( 'thumb'=>true, 'thumbSize'=>array ( 400 , 250 ) ) );
            $model->attributes = $_POST['Post'];
            if ( is_array( $file ) ) {
                $model->attach_status = 'Y';
                $model->attach_file = $file['pathname'];
                $model->attach_thumb = $file['paththumbname'];
            }
            $model->title_style = $styleFormat['text'];
            $model->title_style_serialize = $styleFormat['serialize'];
            $model->acl = is_array( $acl )? implode( ',', $acl ): '';
            $model->image_list = $imageListSerialize['dataSerialize'];
            if ($model->save() ) {
                Attr::create( $model->id,  $attr );
                Post2tags::build( 'create', $_POST['Post']['tags'], $model->id, $model->catalog_id );
                parent::_adminiLogger( array ( 'catalog' => 'create' , 'intro' => '录入内容,ID:' . $model->id ) ); 
                $this->redirect( array ( 'index' ) );
            }
        }
        $attrData =  Attr::dataReset($attr);
        $attrModel = Attr::lists( $model->catalog_id, 'post' );
        $this->render( 'create', array ( 'model' => $model, 'imageList'=>$imageListSerialize['data'], 'attrModel'=>$attrModel ,'attrData'=>$attrData   ) );
    }

    /**
     * 更新
     *
     * @param  $id
     */
    public function actionUpdate( $id ) {
        parent::_acl();
        $attr = $this->_gets->getParam( 'attr' );
        $model = parent::_dataLoad( new Post(), $id );
        $imageList = $this->_gets->getParam( 'imageList' );
        $imageListSerialize = XUtils::imageListSerialize($imageList);
        if ( isset( $_POST['Post'] ) ) {
            $style = $this->_gets->getParam( 'style' );
            $acl = $this->_gets->getParam( 'acl' );
            $styleFormat = XUtils::titleStyle( $style );
            $model->attributes = $_POST['Post'];
            $file = XUpload::upload( $_FILES['attach'], array( 'thumb'=>true, 'thumbSize'=>array ( 400 , 250  ) ) );
            if ( is_array( $file ) ) {
                $model->attach_file = $file['pathname'];
                $model->attach_thumb = $file['paththumbname'];
                $model->attach_status = 'Y';
                @unlink( $_POST['oAttach'] );
                @unlink( $_POST['oThumb'] );
            }
            $model->title_style = $styleFormat['text'];
            $model->title_style_serialize = $styleFormat['serialize'];
            $model->acl = is_array( $acl )? implode( ',', $acl ): '';
            $model->image_list = $imageListSerialize['dataSerialize'];
            if ( $model->save() ) {
                Attr::xupdate( $model->id,  $attr );
                Post2tags::build( 'update', $_POST['Post']['tags'], $model->id, $model->catalog_id );
                parent::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '编辑内容,ID:' . $id ) ); 
                $this->redirect( array ( 'index' ) );
            }
        }
        $attrModel = Attr::lists( $model->catalog_id, 'post' );
        if ( $attr )
            $attrData =  Attr::dataReset($attr);
        else
            $attrData = Attr::datas( $model->id );

        if ( $imageList )
            $imageList =  $imageListSerialize['data'];
        elseif($model->image_list)
            $imageList = unserialize($model->image_list);
        $this->render( 'update', array ( 'model' => $model,'imageList'=>$imageList, 'attrModel'=>$attrModel, 'attrData'=>$attrData , 'groupList'=>$this->_groupList( 'user' ) ) );

    }

    /**
     * 评论管理
     *
     */
    public function actionComment() {
        parent::_acl();
        $model = new PostComment();
        $criteria = new CDbCriteria();
        $condition = '1';
        $postTitle = $this->_gets->getParam( 'postTitle' );
        $content = $this->_gets->getParam( 'content' );
        $postTitle && $condition .= ' AND post.title LIKE \'%' . $postTitle . '%\'';
        $content && $condition .= ' AND t.content LIKE \'%' . $content . '%\'';
        $criteria->condition = $condition;
        $criteria->order = 't.id DESC';
        $criteria->with = array ( 'post' );
        $count = $model->count( $criteria );
        $pages = new CPagination( $count );
        $pages->pageSize = 13;
        $pageParams = XUtils::buildCondition( $_GET, array ( 'postTitle' , 'content' ) );
        $pages->params = is_array( $pageParams ) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll( $criteria );
        $this->render( 'post_comment', array ( 'datalist' => $result , 'pagebar' => $pages ) );
    }

    /**
     * 更新
     *
     * @param  $id
     */
    public function actionCommentUpdate( $id ) {
        parent::_acl( 'post_comment_update' );
        $model = parent::_dataLoad( new PostComment(), $id );
        if ( isset( $_POST['PostComment'] ) ) {
            $model->attributes = $_POST['PostComment'];
            if ( $model->save() ) {
                parent::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '编辑内容评论，ID:' . $id ) ); 
                $this->redirect( array ( 'comment' ) );
            }
        }
        $this->render( 'post_comment_update', array ( 'model' => $model ) );
    }

    /**
     * 标签管理
     *
     */
    public function actionPostTags() {
        $model = new PostTags();
        $criteria = new CDbCriteria();
        $condition = '1';
        $tagName = $this->_gets->getParam( 'tagName' );
        $tagName && $condition .= ' AND tag_name LIKE \'%' . $tagName . '%\'';
        $catalog_id = intval( $this->_gets->getParam( 'catalog_id' ) );
        $catalog_id && $condition .= ' AND t.catalog_id= ' . $catalog_id;
        $criteria->condition = $condition;
        $criteria->order = 't.id DESC';
        $criteria->with = 'catalog';
        $count = $model->count( $criteria );
        $pages = new CPagination( $count );
        $pages->pageSize = 13;
        $pageParams = XUtils::buildCondition( $_GET, array ( 'tagName' , 'catalog_id' ) );
        $pages->params = is_array( $pageParams ) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll( $criteria );
        $this->render( 'post_tags', array ( 'datalist' => $result , 'pagebar' => $pages ) );
    }

    /*
     * 专题
     */
    public function actionSpecial() {
        parent::_acl( 'post_special' );
        $model = new Special();
        $criteria = new CDbCriteria();
        $condition = '1';
        $title = $this->_gets->getParam( 'title' );
        $titleAlias = $this->_gets->getParam( 'titleAlias' );
        $title && $condition .= ' AND title LIKE \'%' . $title . '%\'';
        $titleAlias && $condition .= ' AND title_alias LIKE \'%' . $titleAlias . '%\'';
        $criteria->condition = $condition;
        $criteria->order = 't.id DESC';
        $count = $model->count( $criteria );
        $pages = new CPagination( $count );
        $pages->pageSize = 13;
        $pageParams = XUtils::buildCondition( $_GET, array ( 'page_name_alias' , 'page_name' ) );
        $pages->params = is_array( $pageParams ) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll( $criteria );
        $this->render( 'special_index', array ( 'datalist' => $result , 'pagebar' => $pages ) );
    }

    /**
     * 专题录入
     */
    public function actionSpecialCreate() {
        parent::_acl( 'post_special_create' );
        $model = new Special();
        if ( isset( $_POST['Special'] ) ) {
            $model->attributes = $_POST['Special'];
            $file = XUpload::upload( $_FILES['attach'], array( 'thumb'=>true, 'thumbSize'=>array ( 500 , 400 ) )  );
            if ( is_array( $file ) ) {
                $model->attach_file = $file['pathname'];
                $model->attach_thumb = $file['paththumbname'];
            }
            if ( $model->save() ) {
                self::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '专题录入：' . $this->id .',ID:' . $id ) ); 
                $this->redirect( array( 'special' ) );
            }
        }
        $this->render( 'special_create', array ( 'model' => $model ) );
    }

    /**
     * 专题更新
     *
     * @param $id
     */
    public function actionSpecialUpdate( $id ) {
        parent::_acl( 'post_special_update' );
        $model = parent::_dataLoad( new Special(), $id );
        if ( isset( $_POST['Special'] ) ) {
            $model->attributes = $_POST['Special'];
            $file = XUpload::upload( $_FILES['attach'], array( 'thumb'=>true, 'thumbSize'=>array (  500 , 400  ) )  );
            if ( is_array( $file ) ) {
                $model->attach_file = $file['pathname'];
                $model->attach_thumb = $file['paththumbname'];
                @unlink( $_POST['oAttach'] );
                @unlink( $_POST['oThumb'] );
            }
            if ( $model->save() ) {
                self::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '专题更新,ID:' .$model->id ) ); 
                $this->redirect( array( 'special' ) );
            }
        }
        $this->render( 'special_update', array ( 'model' => $model ) );
    }

    /**
     * 批量操作
     *
     */
    public function actionBatch() {
        if ( XUtils::method() == 'GET' ) {
            $command = trim( $_GET['command'] );
            $ids = intval( $_GET['id'] );
        } elseif ( XUtils::method() == 'POST' ) {
            $command = trim( $_POST['command'] );
            $ids = $_POST['id'];
            is_array( $ids ) && $ids = implode( ',', $ids );
        } else {
            XUtils::message( 'errorBack', '只支持POST,GET数据' );
        }
        empty( $ids ) && XUtils::message( 'error', '未选择记录' );

        switch ( $command ) {
        case 'delete':
            parent::_acl( 'post_delete' );
            Post2tags::xdelete( $ids );
            $commentModel = new PostComment();
            $commentModel->deleteAll( 'post_id IN(' . $ids . ')' );
            parent::_adminiLogger( array ( 'catalog' => 'delete' , 'intro' => '删除内容，ID:' . $ids ) ); 
            parent::_delete( new Post(), $ids, array ( 'index' ), array( 'attach_file', 'attach_thumb' ) );
            break;
        case 'commentDelete':
            parent::_acl( 'post_comment_delete' );
            parent::_adminiLogger( array ( 'catalog' => 'delete' , 'intro' => '删除内容评论，ID:' . $ids ) ); 
            parent::_delete( new PostComment(), $ids, array ( 'comment' ) );
            break;
        case 'commentVerify':
            parent::_acl( 'post_comment_verify' );
            parent::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '审核评论，ID:' . $ids ) ); 
            parent::_verify( new PostComment(), 'verify', $ids, array ( 'comment' ) );
            break;
        case 'commentUnVerify':
            parent::_acl( 'post_comment_verify' );
            parent::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '取消评论审核，ID:' . $ids ) ); 
            parent::_verify( new PostComment(), 'unVerify', $ids, array ( 'comment' ) );
            break;
        case 'verify':
            parent::_acl( 'post_verify' );
            parent::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '批量审核内容，ID:' . $ids ) ); 
            parent::_verify( new Post(), 'verify', $ids, array ( 'index' ) );
            break;
        case 'unVerify':
            parent::_acl( 'post_verify' );
            parent::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '批量取消内容审核，ID:' . $ids ) ); 
            parent::_verify( new Post(), 'unVerify', $ids, array ( 'index' ) );
            break;
        case 'commend':
            parent::_acl( 'post_commend' );
            parent::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '批量推荐内容，ID:' . $ids ) ); 
            parent::_commend( new Post(), 'commend', $ids, array ( 'index' ) );
            break;
        case 'unCommend':
            parent::_acl( 'post_commend' );
            parent::_adminiLogger( array ( 'catalog' => 'update' , 'intro' => '批量取消内容推荐，ID:' . $ids ) ); 
            parent::_commend( new Post(), 'unCommend', $ids, array ( 'index' ) );
            break;
        case 'specialDelete':
            parent::_acl( 'post_special_delete' );
            parent::_adminiLogger( array ( 'catalog' => 'delete' , 'intro' => '删除内容，ID:' . $ids ) ); 
            parent::_delete( new Special(), $ids, array ( 'special' ), array( 'attach_file', 'attach_thumb' ) );
            break;
        default:
            throw new CHttpException(404, '错误的操作类型:' . $command);
            break;
        }
    }
}
