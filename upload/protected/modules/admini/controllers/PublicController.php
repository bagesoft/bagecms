<?php
/**
 * 公共登录
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class PublicController extends Controller
{

    /**
     * 会员登录
     */
    public function actionLogin ()
    {
        $model = new Admin('login');
        if (XUtils::method() == 'POST') {
            $model->attributes = $_POST['Admin'];
            if ($model->validate()) {
                $data = $model->find('username=:username', array ('username' => $model->username ));
                if ($data === null) {
                    $model->addError('username', '用户不存在');
                    parent::_adminiLogger(array ('catalog' => 'login' , 'intro' => '登录失败，用户不存在:' . $model->username , 'user_id' => 0 ));
                } elseif (! $model->validatePassword($data->password)) {
                    $model->addError('password', '密码不正确');
                    parent::_adminiLogger(array ('catalog' => 'login' , 'intro' => '登录失败，密码不正确:' . $model->username. '，使用密码：'.$model->password , 'user_id' => 0 ));
                } elseif ($data->group_id == 2) {
                    $model->addError('username', '用户已经锁定，请联系管理');
                } else {
                    $session = new XSession();
                    $session->set('_adminiUserId', $data->id);
                    $session->set('_adminiUserName', $data->username);
                    $session->set('_adminiGroupId', $data->group_id);
                    if ($data->group_id == 1)
                        $session->set('_adminiPermission', 'administrator');
                    $data->last_login_ip = XUtils::getClientIP();
                    $data->last_login_time = time();
                    $data->login_count = $data->login_count+1;
                    $data->save();
                    parent::_adminiLogger(array ('catalog' => 'login' , 'intro' => '用户登录成功:'.$model->username ));
                    $this->redirect(array('default/index'));
                    XUtils::message('success', '登录成功', $this->createUrl('default/index'),2 );
                }
            }
        }
        $this->render('login', array ('model' => $model ));
    }

    /**
     * 退出登录
     */
    public function actionLogout ()
    {
        parent::_sessionRemove('_adminiUserId');
        parent::_sessionRemove('_adminiUsername');
        parent::_sessionRemove('_adminiGroupId');
        parent::_sessionRemove('_adminiPermission');
        $this->redirect(array ('public/login' ));
    }

}

?>