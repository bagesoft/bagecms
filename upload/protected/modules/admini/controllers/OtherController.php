<?php
/**
 * 其它管理
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class OtherController extends XAdminiBase
{
    
    /**
	 * 附件管理
	 */
    public function actionAttach ()
    {
        parent::_acl('attach_index');
        $model = new Upload();
        $criteria = new CDbCriteria();
        $condition = '1';
        $realname = trim($this->_gets->getParam('realname'));
        $filename = trim($this->_gets->getParam('file'));
        $realname && $condition .= ' AND t.real_name LIKE \'%' . $realname . '%\'';
        $filename && $condition .= ' AND t.file_name LIKE \'%' . $filename . '%\'';
        $criteria->condition = $condition;
        // $criteria->params = '';
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        
        $pages = new CPagination($count);
        $pages->pageSize = 13;
        $pageParams = XUtils::buildCondition($_GET, array ('filename' , 'nickname' ));
        $pages->params = is_array($pageParams) ? $pageParams : array ();
        
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('attach_index', array ('datalist' => $result , 'pagebar' => $pages ));
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
            case 'attachDelete':
                parent::_acl('attach_delete');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'删除附件，ID:'.$ids));//日志
                parent::_delete(new Upload(), $ids, array ('attach' ), array ('file_name' ));
                break;
            default:
                throw new CHttpException(404, '错误的操作类型:' . $command);
                break;
        }
    
    }

}