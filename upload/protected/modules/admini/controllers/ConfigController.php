<?php
/**
 * 系统配置
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class ConfigController extends XAdminiBase
{

    /**
     * 取配置数据
     *
     */
    public function loadData ()
    {
        $model = Config::model()->findAll();
        foreach ($model as $key => $row) {
            $config[$row['variable']] = $row['value'];
        }
        return $config;
    
    }

    /**
     * 更新数据
     *
     */
    private function _updateData ($data, $scope = 'base')
    {
        if (XUtils::method() == 'POST') {
            foreach ((array) $data as $key => $row) {
                $row = XUtils::addslashes($row);
                $connection = Yii::app()->db->createCommand("REPLACE INTO {{config}}(`scope`, `variable`, `value`) VALUES('$scope','$key', '$row') ")->execute();
            }
            XXcache::refresh('_config', 3600);
            parent::_adminiLogger(array ('catalog' => 'update' , 'intro' => '更新系统配置，模块：' . $this->action->id )); 
            XUtils::message('success', '更新完成', $this->createUrl($this->action->id));
        }
    
    }

    /**
     * 基本配置首页
     *
     */
    public function actionIndex ()
    {
        parent::_acl(); 
        self::_updateData($_POST['Config']);
        $this->render('index', array ('config' => self::loadData() ));
    
    }

    /**
     * seo设置
     *
     */
    public function actionSeo ()
    {
        parent::_acl(); 
        self::_updateData($_POST['Config']);
        $this->render('seo', array ('config' => self::loadData() ));
    }

    /**
     * 邮件设置
     *
     */
    public function actionMail ()
    {
        parent::_acl(); 
        self::_updateData($_POST['Config'], 'mail');
        $this->render('mail', array ('config' => self::loadData() ));
    }

    /**
     * 第三方登录设置
     *
     */
    public function actionOauth ()
    {
        parent::_acl(); 
        self::_updateData($_POST['Config'], 'oauth');
        $this->render('oauth', array ('config' => self::loadData() ));
    }


    /**
     * 会员设置
     *
     */
    public function actionUserConfig ()
    {
        parent::_acl(); 
        self::_updateData($_POST['Config'], 'base');
        $this->render('user', array ('config' => self::loadData() ));
    }

    /**
     * 邮件模板
     *
     */
    public function actionSendTpl ()
    {
        parent::_acl('send_tpl'); 
        $result = SendTpl::model()->findAll(array ('order' => 'id DESC' ));
        $this->render('send_tpl', array ('datalist' => $result ));
    }

    /**
     * 录入
     *
     */
    public function actionSendTplCreate ()
    {
        parent::_acl('send_tpl_create'); 
        parent::_create(new SendTpl(), array ('sendTpl' ), 'send_tpl_create');
    }

    /**
     * 更新
     *
     * @param unknown_type $id
     */
    public function actionSendTplUpdate ($id)
    {
        parent::_acl('send_tpl_update'); 
        parent::_update(new SendTpl(), array ('sendTpl' ), 'send_tpl_update', $id);
    
    }

    /**
     * 短信
     *
     */
    public function actionSms ()
    {
        parent::_acl(); 
        self::_updateData($_POST['Config'], 'sms');
        $this->render('sms', array ('config' => self::loadData() ));
    }

    /**
     * 银行
     *
     */
    public function actionEbank ()
    {
        parent::_acl(); 
        self::_updateData($_POST['Config'], 'base');
        $this->render('ebank', array ('config' => self::loadData() ));
    }

    /**
     * 更新备忘
     *
     */
    public function actionUpdateNotebook ()
    {
        $notebook = $this->_gets->getParam('notebook');
        $model = Admin::model()->findByPk($this->_fangAdminUserId);
        $model->notebook = trim($notebook);
        if ($model->save()) {
            exit('更新完成');
        } else {
            exit('更新失败');
        }
    }

    /**
     * 自定义字段
     */
    public function actionCustom ()
    {
        parent::_acl(); 
       
        if (XUtils::method() == 'POST') {
            foreach ((array) $_POST['attr'] as $key => $row) {

                $val = is_array( $row['val'] ) ? implode( ',', $row['val'] ) : $row['val'];
                $var = $row["name"];
                $connection = Yii::app()->db->createCommand("REPLACE INTO {{config}}(`scope`, `variable`, `value`) VALUES('custom','$var', '$val') ")->execute();
            }
            XXcache::refresh('_config', 3600);
            parent::_adminiLogger(array ('catalog' => 'update' , 'intro' => '更新系统配置，模块：' . $this->action->id )); 
            XUtils::message('success', '更新完成', $this->createUrl($this->action->id));
        }

        $attrModel = Attr::lists(0, 'config');
        $this->render('custom', array ('attrData' => self::loadData() , 'attrModel' => $attrModel));
    }
    
    /**
     * 附件设置
     */
    public function actionUpload(){
        parent::_acl(); 
        self::_updateData($_POST['Config'], 'base');
        $this->render('upload', array ('config' => self::loadData() ));
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
            
            case 'sendTplDelete':
                parent::_acl('send_tpl_delete'); 
                parent::_adminiLogger(array ('catalog' => 'delete' , 'intro' => '删除信息模板，ID:' . $ids )); 
                parent::_delete(new SendTpl(), $ids, array ('sendTpl' ));
                break;
            default:
                throw new CHttpException(404, '错误的操作类型:' . $command);
                break;
        }
    
    }

}