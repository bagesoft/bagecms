<?php
/**
 * 系统日志
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class LoggerController extends XAdminiBase
{

    /*
     * 管理员日志
    */
    public function actionAdmin ()
    {
        parent::_acl('admin_logger');
        $model = new AdminLogger();
        $criteria = new CDbCriteria();
        $condition = '1';
        $username = $this->_gets->getParam('username');
        $catalog = $this->_gets->getParam('catalog');
        $username && $condition .= ' AND admin.username= \'' . $username . '\'';
        $catalog && $condition .= ' AND t.catalog= \'' . $catalog . '\'';
        $criteria->condition = $condition;
        $criteria->order = 't.id DESC';
        $criteria->with = 'admin';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 40;
        $pageParams = XUtils::buildCondition($_GET, array ('username' , 'catalog' ));
        $pages->params = is_array($pageParams) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('admin_logger', array ('datalist' => $result , 'pagebar' => $pages ));
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
            case 'adminLoggerDelete':
                parent::_acl('admin_logger_delete');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'删除管理员操作日志'));
                parent::_delete(new AdminLogger(), $ids, array ('admin' ));
                break;
            default:
                throw new CHttpException(404, '错误的操作类型:' . $command);
                break;
        }
    
    }

}