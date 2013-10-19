<?php
/**
 * 单页控制器
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class PageController extends XFrontBase
{
  /**
  * 浏览
  */
  public function actionShow( $name ) {
    $bagecmsPageModel = Page::model()->find('title_alias=:titleAlias', array('titleAlias'=>CHtml::encode(strip_tags($name))));
    if ( false == $bagecmsPageModel )
      throw new CHttpException( 404, '内容不存在' );
    $this->_seoTitle = empty( $bagecmsPageModel->seo_title ) ? $bagecmsPageModel->title .' - '. $this->_conf['site_name'] : $bagecmsPageModel->seo_title;
    $tpl = empty($bagecmsPageModel->tpl) ? 'show': $bagecmsPageModel->tpl ;
    $this->render( 'show', array( 'bagecmsPage'=>$bagecmsPageModel ) );
  }

}
