<?php
/**
 * 常用操作
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class OperationController extends XAdminiBase
{
    /**
     * 首页
     */
    public function actionIndex ()
    {
        $this->render('index');
    }

    /**
	 * 链接
	 */
    public function actionLink ()
    {
        parent::_acl('link_index');
        $model = new Link();
        $criteria = new CDbCriteria();
        $condition = '1';
        $siteName = trim($this->_gets->getParam('siteName'));
        $siteName && $condition .= ' AND site_name LIKE \'%' . $siteName . '%\'';
        $criteria->condition = $condition;
        //$criteria->params = '';
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 13;
        $pageParams = XUtils::buildCondition($_GET, array ('site_name' ));
        $pages->params = is_array($pageParams) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('link_index', array ('datalist' => $result , 'pagebar' => $pages ));
    }
    
    /**
     * 链接录入
     *
     */
    public function actionLinkCreate ()
    {
        parent::_acl('link_create');
        $model = new Link();
        if (isset($_POST['Link'])) {
            $model->attributes = $_POST['Link'];
            $file = XUpload::upload($_FILES['attach']);
            if (is_array($file)) {
                $model->attach_file = $file['pathname'];
                $model->link_type = 'image';
            }
            if ($model->save()) {
                XXcache::refresh('_link');
                parent::_adminiLogger(array('catalog'=>'create', 'intro'=>'录入友情链接，ID:'.$model->id));
                $this->redirect(array ('link' ));
            }
        }
        
        $this->render('link_create', array ('model' => $model ));
    
    }

    /**
	 * 更新链接
	 *
	 */
    public function actionLinkUpdate ($id)
    {
        parent::_acl('link_update');
        $model = parent::_dataLoad(new Link(), $id);
        if (isset($_POST['Link'])) {
            $remove = $this->_gets->getParam('remove');
            $model->attributes = $_POST['Link'];
            if ($remove=='Y') {
                $model->link_type = 'txt';
                $model->attach_file = '';
                @unlink($_POST['oAttach']);
            }else{
                $file = XUpload::upload($_FILES['attach']);
                if (is_array($file)) {
                    $model->attach_file = $file['pathname'];
                    $model->link_type = 'image';
                    @unlink($_POST['oAttach']);
                }
            }

            if ($model->save()) {
                XXcache::refresh('_link');
                parent::_adminiLogger(array('catalog'=>'create', 'intro'=>'编辑友情链接，ID:'.$id));
                $this->redirect(array ('link' ));
            }
        }
        $this->render('link_update', array ('model' => $model ));
    
    }

    /**
	 * 广告管理
	 *
	 */
    public function actionAd ()
    {
        parent::_acl('ad_index');
        $model = new Ad();
        $criteria = new CDbCriteria();
        $condition = '1';
        $title = $this->_gets->getParam('title');
        $title && $condition .= ' AND title LIKE \'%' . $title . '%\'';
        $criteria->condition = $condition;
        //$criteria->params = '';
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 13;
        $pageParams = XUtils::buildCondition($_GET, array ('title' ));
        $pages->params = is_array($pageParams) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('ad_index', array ('datalist' => $result , 'pagebar' => $pages ));
    }

    /**
	 * 广告录入
	 *
	 */
    public function actionAdCreate ()
    {
        parent::_acl('ad_create');
        $model = new Ad();
        if (isset($_POST['Ad'])) {
            $model->attributes = $_POST['Ad'];
            $file = XUpload::upload($_FILES['attach']);
            if (is_array($file)) {
                $model->attach_file = $file['pathname'];
            }
            $model->expired_time = intval(strtotime($model->expired_time));
            $model->start_time = intval(strtotime($model->start_time));
            if ($model->save()) {
                XXcache::refresh('_ad');
                parent::_adminiLogger(array('catalog'=>'create', 'intro'=>'录入广告，ID:'.$model->id));
                $this->redirect(array ('ad' ));
            }
        }
        $model->start_time = date('Y-m-d');
        $model->expired_time = date('Y-m-d', time() + 86499);
        $this->render('ad_create', array ('model' => $model ));
    }

    /**
	 * 更新广告
	 */
    public function actionAdUpdate ($id)
    {
        parent::_acl('ad_update');
        $model = parent::_dataLoad(new Ad(), $id);
        if (isset($_POST['Ad'])) {
            $file = XUpload::upload($_FILES['attach']);
            if (is_array($file)) {
                $model->attach_file = $file['pathname'];
                @unlink($_POST['oAttach']);
            }
            $model->attributes = $_POST['Ad'];
            $model->expired_time = intval(strtotime($model->expired_time));
            $model->start_time = intval(strtotime($model->start_time));
            if ($model->save()) {
                XXcache::refresh('_ad');
                parent::_adminiLogger(array('catalog'=>'update', 'intro'=>'编辑广告，ID:'.$id));
                $this->redirect(array ('ad' ));
            }
        }
        $model->expired_time = date('Y-m-d', $model->expired_time);
        $model->start_time = date('Y-m-d', $model->start_time);
        $this->render('ad_update', array ('model' => $model ));
    
    }

    /**
	 * 批量操作
	 *
	 */
    public function actionBatch ()
    {
        if (XUtils::method() == 'GET') {
            $command = trim($_GET['command']);
            $ids = intval($_GET['id']);
        } else 
            if (XUtils::method() == 'POST') {
                $command = trim($_POST['command']);
                $ids = $_POST['id'];
                is_array($ids) && $ids = implode(',', $ids);
            } else {
                XUtils::message('errorBack', '只支持POST,GET数据');
            }
        empty($ids) && XUtils::message('error', '未选择记录');
        
        switch ($command) {
            case 'linkDelete':
                parent::_acl('link_delete');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'删除链接，ID:'.$ids));
                parent::_delete(new Link(), $ids, array ('link' ), array ('attach_file' ));
                break;
            case 'adDelete':
                parent::_acl('ad_delete');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'删除广告，ID:'.$ids));
                parent::_delete(new Ad(), $ids, array ('ad' ), array ('attach_file' ));
                break;
            case 'linkVerify':
                parent::_acl('link_verify');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'链接状态变更为显示，ID:'.$ids));
                parent::_verify(new Link(), 'verify', $ids, array ('link' ));
                break;
            case 'linkUnVerify':
                parent::_acl('link_verify');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'链接状态变更为隐藏，ID:'.$ids));
                parent::_verify(new Link(), 'unVerify', $ids, array ('link' ));
                break;
            case 'adVerify':
                parent::_acl('ad_verify');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'广告状态变更为显示，ID:'.$ids));
                parent::_verify(new Ad(), 'verify', $ids, array ('ad' ));
                break;
            case 'adUnVerify':
                parent::_acl('ad_verify');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'广告状态变更为隐藏，ID:'.$ids));
                parent::_verify(new Ad(), 'unVerify', $ids, array ('ad' ));
                break;
            default:
                throw new CHttpException(404, '错误的操作类型:' . $command);
                break;
        }
    
    }

}