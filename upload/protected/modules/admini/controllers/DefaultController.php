<?php
/**
 * 系统首页
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class DefaultController extends XAdminiBase
{
    /**
     * 首页
     */
    public function actionIndex ()
    {
        $this->render('index');
    }
    
    /**
	 * 主界面
	 */
    public function actionHome ()
    {
        $data['soft'] = 'bagecms';
        $data['softVersion'] = $this->_bagecms;
        $data['softRelease'] = $this->_bagecmsRelease;
        $data['serverSoft'] = $_SERVER['SERVER_SOFTWARE'];
        $data['serverOs'] = PHP_OS;
        $data['phpVersion'] = PHP_VERSION;
        $data['fileupload'] = ini_get('file_uploads') ? ini_get('upload_max_filesize') : '禁止上传';
        $data['serverUri'] = $_SERVER['SERVER_NAME'];
        $data['maxExcuteTime'] = ini_get('max_execution_time') . ' 秒';
        $data['maxExcuteMemory'] = ini_get('memory_limit');
        $data['magic_quote_gpc'] = MAGIC_QUOTE_GPC ? '开启' : '关闭';
        $data['allow_url_fopen'] = ini_get('allow_url_fopen') ? '开启' : '关闭';
        $data['excuteUseMemory'] = function_exists('memory_get_usage') ? XUtils::byteFormat(memory_get_usage()) : '未知';
        $dbsize = 0;
        $connection = Yii::app()->db;
        $sql = 'SHOW TABLE STATUS LIKE \'' . $connection->tablePrefix . '%\'';
        $command = $connection->createCommand($sql)->queryAll();
        foreach ($command as $table) 
            $dbsize += $table['Data_length'] + $table['Index_length'];
        $mysqlVersion = $connection->createCommand("SELECT version() AS version")->queryAll();
        $data['mysqlVersion'] = $mysqlVersion[0]['version'];
        $data['dbsize'] = $dbsize ? XUtils::byteFormat($dbsize) : '未知';
        $notebook = Admin::model()->findByPk($this->_adminiUserId);
        $env = XUtils::b64encode(serialize($data));
        $this->render('home', array ('notebook' => $notebook ,'env'=>$env, 'server' => $data ));
    }

    /**
     * 更新备注
     */
    public function actionNotebookUpdate ()
    {
        try {
            $notebook = $this->_gets->getPost('notebook');
            $adminModel = Admin::model()->findByPk($this->_adminiUserId);
            if($adminModel == false)
                throw new Exception('管理员不存在');
            $adminModel->notebook = trim($notebook);
            if ($adminModel->save()) {
                $var['state'] = 'success';
                $var['message'] = '更新成功';
            }else {
                throw new Exception('更新失败');
            }
        } catch (Exception $e) {
            $var['state'] = 'error';
            $var['message'] = $e->getMessage();
        }
        exit(CJSON::encode($var));
    }
}