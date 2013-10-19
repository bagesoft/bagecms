<?php
/**
 * 管理员
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class AdminController extends XAdminiBase
{
    protected $group_list;
    
    /**
     * 管理员列表
     *
     */
    public function actionIndex ()
    {
        parent::_acl(); 
        $model = new Admin();
        $criteria = new CDbCriteria();
        $criteria->condition = "t.status_is='Y'";
        $criteria->order = 't.id DESC';
        $criteria->with = 'adminGroup';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 13;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('admin_index', array ('datalist' => $result , 'pagebar' => $pages ));
    }

    /**
     * 管理员录入
     *
     */
    public function actionCreate ()
    {
        parent::_acl(); 
        $model = new Admin('create');
        if (isset($_POST['Admin'])) {
            $model->attributes = $_POST['Admin'];
            $id = $model->save();
            if ($id) {
                parent::_adminiLogger(array ('catalog' => 'create' , 'intro' => '录入管理员:' . $model->username )); 
                $this->redirect(array ('index' ));
            }
        }
        $this->group_list = parent::_groupList('admin');
        $model->create_time = date('Y-m-d');
        $model->last_login_time = date('Y-m-d');
        $this->render('admin_create', array ('model' => $model ));
    }

    /**
     * 管理员编辑
     *
     * @param  $id
     */
    public function actionUpdate ($id)
    {
        parent::_acl(); 
        $model = parent::_dataLoad(new Admin(), $id);
        
        if (isset($_POST['Admin'])) {
            $password = $_POST['Admin']['password'];
            if (empty($password)) 
                $_POST['Admin']['password'] = $model->password;
            else 
                $_POST['Admin']['password'] = md5($password);
            
            $model->attributes = $_POST['Admin'];
            
            if ($model->save()) {
                parent::_adminiLogger(array ('catalog' => 'update' , 'intro' => '更新管理员资料:' . $model->username )); 
                $this->redirect(array ('index' ));
            }
        }
        $this->group_list = parent::_groupList('admin');
        $this->render('admin_update', array ('model' => $model ));
    
    }

    /**
     * 管理员组
     *
     */
    public function actionGroup ()
    {
        parent::_acl(); 
        $model = new AdminGroup();
        $criteria = new CDbCriteria();
        $criteria->order = 't.id DESC';
        $count = $model->count($criteria);
        $pages = new CPagination($count);
        $pages->pageSize = 13;
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll($criteria);
        $this->render('admin_group', array ('datalist' => $result , 'pagebar' => $pages ));
    }

    /**
     * 管理组录入
     *
     */
    public function actionGroupCreate ()
    {
        parent::_acl(); 
        $model = new AdminGroup();
        if (isset($_POST['AdminGroup'])) {
            $model->attributes = $_POST['AdminGroup'];
            $acl = Yii::app()->request->getPost('acl');
            if (is_array($acl)) 
                $model->acl = implode(',', array_unique($acl));
             else 
                $model->acl = 'administrator';
            if ($model->save()) {
                parent::_adminiLogger(array ('catalog' => 'create' , 'intro' => '录入管理员组' . $model->group_name ));
                $this->redirect(array ('group' ));
            }
        }
        $this->render('group_create', array ('model' => $model ));
    }

    /**
     * 管理员组编辑
     *
     * @param  $id
     */
    public function actionGroupUpdate ($id)
    {
        parent::_acl(); 
        parent::_groupPrivate($id);
        $data = parent::_dataLoad(new AdminGroup(), $id);
        if (isset($_POST['AdminGroup'])) {
            $data->attributes = $_POST['AdminGroup'];
            $acl = Yii::app()->request->getParam('acl');
            if (is_array($acl))
                $data->acl = implode(',', array_unique($acl));
            else 
                $data->acl = 'administrator';
            if ($data->save()) {
                parent::_adminiLogger(array ('catalog' => 'create' , 'intro' => '编辑管理员组' . $data->group_name ));
                $this->redirect(array ('group' ));
            }
        }
        
        $this->render('group_update', array ('model' => $data ));
    }

    /**
     * 修改密码
     */
    public function actionOwnerUpdate ()
    {
        $model = parent::_dataLoad(new Admin(), $this->_adminiUserId);
        
        if (isset($_POST['Admin'])) {
            $password = $_POST['Admin']['password'];
            if (empty($password))
                $_POST['Admin']['password'] = $model->password;
             else 
                $_POST['Admin']['password'] = md5($password);
            $model->attributes = $_POST['Admin'];
            $model->password = empty($password) ? $model->password : md5($password);
            if ($model->save()) {
                parent::_adminiLogger(array ('catalog' => 'update' , 'intro' => '修改密码:' . $model->username )); //日志
                XUtils::message('success', '修改完成', $this->createUrl('default/home'));
            }
        }
        $this->render('owner_update', array ('model' => $model ));
    
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
            $ids = $this->_gets->getPost('id');
            is_array($ids) && $ids = implode(',', $ids);
        } else {
            XUtils::message('errorBack', '只支持POST,GET数据');
        }
        empty($ids) && XUtils::message('error', '未选择记录');
        
        switch ($command) {
            
            case 'adminDelete':
                parent::_acl('admin_delete');
                parent::_adminiLogger(array ('catalog' => 'delete' , 'intro' => '删除管理员,ID:' . $ids ));
                parent::_delete(new Admin(), $ids, array ('index' ));
                break;
            case 'groupDelete':
                parent::_acl('admin_group_delete');
                parent::_groupPrivate($ids);
                parent::_adminiLogger(array ('catalog' => 'delete' , 'intro' => '删除管理员用户组,ID:' . $ids ));
                parent::_delete(new AdminGroup(), $ids, array ('group' ));
                break;
            default:
                throw new CHttpException(404, '错误的操作类型:' . $command);
                break;
        }
    
    }

}
