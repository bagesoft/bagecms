<?php
/**
 * 后台管理模块
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Module
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class AdminiModule extends CWebModule
{
	/*public function init()
	{
		// import the module-level models and components
		//导 入类，必要时可恢复此属性
		 $this->setImport(array(
			'admini.models.*',
			'admini.components.*',
		)); 
	}*/

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}
}
