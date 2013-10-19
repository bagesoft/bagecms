<?php
/**
 * Http工具类
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Tools
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class XHttp{

	/**
	 * 文件下载
	 */
	static function download ($filename, $showname='', $content='',$expire=180){
		Yii::import( 'application.vendors.*' );
        require_once 'Tp/Http.class.php';
        Http::download($filename, $showname, $content,$expire);
	}
}


