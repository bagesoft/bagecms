<?php
/**
 * 单页管理
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class PageController extends XAdminiBase
{
    /*
	 * 首页
	 */
    public function actionIndex ()
    {
        parent::_acl();
        $model = new Page();
        $criteria = new CDbCriteria();
        $condition = '1';
        $title = $this->_gets->getParam('title');
        $titleAlias = $this->_gets->getParam('titleAlias');
        $title && $condition .= ' AND title LIKE \'%' . $title . '%\'';
        $titleAlias && $condition .= ' AND title_alias LIKE \'%' . $titleAlias . '%\'';
        $criteria->condition = $condition;
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 13;
        $pageParams = XUtils::buildCondition($_GET, array ('page_name_alias' , 'page_name' ));
        $pages->params = is_array($pageParams) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('index', array ('datalist' => $result , 'pagebar' => $pages ));
    }

    /**
	 * 单页更新
	 */
    public function actionCreate ()
    {
        parent::_acl();
        $model = new Page();
        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
            $file = XUpload::upload($_FILES['attach'], array( 'thumb'=>true, 'thumbSize'=>array ( 200 , 180 ) ));
            if ( is_array( $file ) ) {
                $model->attach_file = $file['pathname'];
                $model->attach_thumb = $file['paththumbname'];
            }
            if ($model->save()) {
                parent::_adminiLogger(array('catalog'=>'create', 'intro'=>'录入单页，ID:'.$model->id));
                $this->redirect(array ('index' ));
            }
        }
        $this->render('create', array ('model' => $model ));
    }

    /**
	 * 单页更新
	 *
	 * @param $id        	
	 */
    public function actionUpdate ($id)
    {
        parent::_acl();
        $model = parent::_dataLoad(new Page(), $id);
        if (isset($_POST['Page'])) {
            $model->attributes = $_POST['Page'];
                $file = XUpload::upload($_FILES['attach'], array( 'thumb'=>true, 'thumbSize'=>array ( 200 , 180 ) ));
                if (is_array($file)) {
                   $model->attach_file = $file['pathname'];
                    $model->attach_thumb = $file['paththumbname'];
                    @unlink($_POST['oAttach']);
                    @unlink($_POST['oThumb']);
                }
            if ($model->save()) {
                XXcache::refresh('_link');
                parent::_adminiLogger(array('catalog'=>'update', 'intro'=>'编辑单页，ID:'.$id));
                $this->redirect(array ('index' ));
            }
        }
        $this->render('update', array ('model' => $model ));
    
    }
    
    /**
	 * 批量操作
	 */
    public function actionBatch ()
    {
        if (XUtils::method() == 'GET') {
            $command = trim($this->_gets->getParam('command'));
            $ids = intval($this->_gets->getParam('id'));
        } elseif (XUtils::method() == 'POST') {
            $command = $this->_gets->getPost('command');
            $ids = $this->_gets->getPost('id');
            is_array($ids) && $ids = implode(',', $ids);
        } else {
            throw new CHttpException(404, '只支持POST,GET数据');
        }
        empty($ids) && XUtils::message('error', '未选择记录');
        
        switch ($command) {
            case 'delete':
                parent::_acl('page_delete');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'删除单页，ID:'.$ids));
                parent::_delete(new Page(), $ids, array ('index' ),array('attach_file', 'attach_thumb'));
                break;
            default:
                throw new CHttpException(404, '错误的操作类型:' . $command);
                break;
        }
    }

}