<?php
/**
 * 入口
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

error_reporting(E_ERROR | E_WARNING | E_PARSE);
$framework = dirname(__FILE__) . '/framework/yiilite.php';
$config = dirname(__FILE__) . '/protected/config/main.php';
define('WWWPATH', str_replace(array('\\', '\\\\'), '/', dirname(__FILE__)));
define('DS', DIRECTORY_SEPARATOR);
require_once ($framework);
Yii::createWebApplication($config)->run();