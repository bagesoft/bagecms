<?php
/**
 * 扩展属性
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class AttrController extends XAdminiBase
{
    /**
     * 属性首页
     */
    public function actionIndex ()
    {
        parent::_acl();
        $model = new Attr();
        $criteria = new CDbCriteria();
        $condition = '1';
        $criteria->condition = $condition;
        $criteria->order = 't.scope DESC,t.sort_order DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 13;
        $pageParams = XUtils::buildCondition($_GET, array ());
        $pages->params = is_array($pageParams) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('index', array ('datalist' => $result , 'pagebar' => $pages ));
    }

    /**
     * 录入属性
     */
    public function actionCreate ()
    {
        parent::_acl();
        $model = new Attr();
        if (isset($_POST['Attr'])) {
            $model->attributes = $_POST['Attr'];
            if ($model->save()) {
                parent::_adminiLogger(array ('catalog' => 'create' , 'intro' => '录入属性，ID:' . $model->id ));
                $this->redirect(array ('index' ));
            }
        }
        $this->render('create', array ('model' => $model ));
    }

   /**
    * 编辑属性
    */
    public function actionUpdate ($id)
    {
        parent::_acl();
        $model = parent::_dataLoad(new Attr(), $id);
        if (isset($_POST['Attr'])) {
            $oldScope = $model->scope;
            $model->attributes = $_POST['Attr'];
            if($oldScope =='post' && $model->scope == 'config' )
                Attr::clear(array('attrId'=>$model->id, 'oldScope'=>$oldScope));
            elseif ($oldScope =='config' && $model->scope == 'post' ) 
                Attr::clear(array('attrId'=>$model->id, 'oldScope'=>$oldScope, 'attrName'=>$model->attr_name_alias));
            if ($model->save()) {
                parent::_adminiLogger(array ('catalog' => 'update' , 'intro' => '编辑属性，ID:' . $id ));
                $this->redirect(array ('index' ));
            }
        }
        $this->render('update', array ('model' => $model ));
    
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
        } elseif (XUtils::method() == 'POST') {
            $command = trim($_POST['command']);
            $ids = $_POST['id'];
            is_array($ids) && $ids = implode(',', $id);
        } else {
            XUtils::message('errorBack', '只支持POST,GET数据');
        }
        empty($ids) && XUtils::message('error', '未选择记录');
        
        switch ($command) {
            case 'delete':
                parent::_acl('attr_delete');
                parent::_adminiLogger(array ('catalog' => 'delete' , 'intro' => '属性删除，ID:' . $ids )); 
                $attrModel = Attr::model()->findByPk($ids);
                Attr::clear(array('attrId'=>$attrModel->id, 'attrName'=>$attrModel->attr_name_alias, 'oldScope'=>'all'));
                parent::_delete(new Attr(), $ids, array ('index' ));
                break;
            default:
                throw new CHttpException(404, '错误的操作类型:' . $command);
                break;
        }
    
    }

}
