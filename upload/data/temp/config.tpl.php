<?php
/**
 * 系统配置
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Config
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'BageCMS',
    'language'=>'zh_cn',
    'theme'=>'default',
    'timeZone'=>'Asia/Shanghai',
    'preload'=>array('log'),
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.extensions.*',
	),
    'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'root',
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admini'=>array(
		     'class'=>'application.modules.admini.AdminiModule',
		),
		'account'=>array(
		     'class'=>'application.modules.account.AccountModule',
		)
	),
	'components'=>array(
        'cache'=>array(
           'class'=>'CFileCache',
        ),
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=~dbName~',
			'emulatePrepare' => true,
			'enableParamLogging' => true,
			'enableProfiling'=>true,
			'username' => '~dbUsername~',
			'password' => '~dbPassword~',
			'charset' => 'utf8',
			'tablePrefix' => '~dbPre~',
		),
		'errorHandler'=>array(
            'errorAction'=>'error/index',
        ), 
        'urlManager'=>array(
        	//'urlFormat'=>'path',
        	'showScriptName'=>true,
        	//'urlSuffix'=>'.html',
        	'rules'=>array(
        		'post/<id:\d+>/*'=>'post/show',
        		'post/<id:\d+>_<title:\w+>/*'=>'post/show',
        		'post/catalog/<catalog:[\w-_]+>/*'=>'post/index',
        		'page/show/<name:\w+>/*'=>'page/show',
        		'special/show/<name:[\w-_]+>/*'=>'special/show',
        		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        	),
        ),
	),
);