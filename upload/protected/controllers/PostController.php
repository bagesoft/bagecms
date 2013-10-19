<?php
/**
 * 内容控制器
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */
class PostController extends XFrontBase
{
  /**
   * 首页
   */
  public function actionIndex() {
    $catalog = trim( $this->_gets->getParam( 'catalog' ) );
    $keyword = trim( $this->_gets->getParam( 'keyword' ) );
    $catalogArr = Catalog::alias2idArr( $catalog, $this->_catalog );
    if ( $catalog && $catalogArr ) {
      if ( $catalogArr['display_type'] == 'list' ) {
        $tpl = $catalogArr['template_list'] ?  $catalogArr['template_list'] : 'list_text';
        $resultArr = self::_catalogList( array( 'catalog'=>$catalogArr['id'], 'pageSize'=>$catalogArr['page_size']  ));
      }else {
        $resultArr = self::_catalogItem( array( 'catalog'=>$catalogArr['id'] ) );
        $tpl = empty( $resultArr['bagecmsCatalogShow']->template_page ) ? 'list_page': $resultArr['bagecmsCatalogShow']->template_page ;
      }
    }else {
      $resultArr = self::_catalogList( array( 'keyword'=>$keyword ) );
      $tpl = 'list_text';
    }
    $tplVars = array(
        'catalogArr'=>$catalogArr,
        'catalogChild'=>Catalog::lite(intval($catalogArr['id'])),
    );
    $this->render( $tpl , array_merge($resultArr, $tplVars) );
  }

  /**
   * 获取栏目内容数据
   *
   * @param array   $params
   * @return array  数组
   */
  protected function _catalogList( $params = array() ) {

    $postModel = new Post();
    $postCriteria = new CDbCriteria();
    $condition = '1';
    if ( $params['catalog'] ) {
      $condition .= ' AND t.catalog_id=:catalogId';
      $criteriaParams[':catalogId'] = intval($params['catalog']);
    }
    if ( $params['keyword'] ) {
      $condition .= ' AND t.title=:title';
      $criteriaParams[':title'] = CHtml::encode(strip_tags($params['keyword']));
    }
    $postCriteria->condition = $condition;
    $postCriteria->params = $criteriaParams;
    $postCriteria->order = 't.id DESC';
    $postCriteria->with = 'catalog';
    $count = $postModel->count( $postCriteria );
    $postPages = new CPagination( $count );
    $postPages->pageSize = $params['pageSize'] > 0 ? $params['pageSize'] : 20 ;
    $pageParams = XUtils::buildCondition( $_GET, array ( 'catalog', 'keyword'  ) );
    $postPages->params = is_array( $pageParams ) ? $pageParams : array ();
    $postCriteria->limit = $postPages->pageSize;
    $postCriteria->offset = $postPages->currentPage * $postPages->pageSize;
    $bagecmsDataList = $postModel->findAll( $postCriteria );
    $catalogArr = Catalog::item($params['catalog'], $this->_catalog);
    if($catalogArr){
      $this->_seoTitle = empty($catalogArr['catalog_name'])? $this->_seoTitle : $catalogArr['catalog_name'];
      $bagecmsCatalogData = $catalogArr;
      $this->_seoKeywords = empty($catalogArr['seo_keywords'])? $this->_seoKeywords : $catalogArr['seo_keywords'];
      $this->_seoDescription = empty($catalogArr['seo_description'])? $this->_seoDescription : $catalogArr['seo_description'];
    }
    return array( 'bagecmsDataList'=>$bagecmsDataList, 'bagecmsPagebar'=>$postPages, 'bagecmsCatalogData'=>$bagecmsCatalogData );
  }

  /**
   * 栏目数据读取
   *
   * @param array
   * @return [type]
   */
  protected function _catalogItem( $params = array() ) {
    $catalogModel = Catalog::model()->findByPk( intval($params['catalog']) );
    if ( $catalogModel ){
      $this->_seoTitle = empty($catalogModel->seo_title)? $catalogModel->catalog_name : $catalogModel->seo_title;
      $this->_seoKeywords = $catalogModel->seo_keywords;
      $this->_seoDescription = $catalogModel->seo_description;
      return array( 'bagecmsCatalogShow'=>$catalogModel);
    }else{
      throw new CHttpException( 404, '内容不存在' );
    }
  }

  /**
   * 浏览详细内容
   */
  public function actionShow( $id ) {
    $bagecmsShow = Post::model()->findByPk( intval( $id ) );
    if ( false == $bagecmsShow )
        throw new CHttpException( 404, '内容不存在' );
    //更新浏览次数
    $bagecmsShow->updateCounters(array ('view_count' => 1 ), 'id=:id', array ('id' => $id ));
    //seo信息
    $this->_seoTitle = empty( $bagecmsShow->seo_title ) ? $bagecmsShow->title  .' - '. $this->_conf['site_name'] : $bagecmsShow->seo_title;
    $this->_seoKeywords = empty( $bagecmsShow->seo_keywords ) ? $this->_seoKeywords  : $bagecmsShow->seo_keywords;
    $this->_seoDescription = empty( $bagecmsShow->seo_description ) ? $this->_seoDescription: $bagecmsShow->seo_description;
    $catalogArr = Catalog::item($bagecmsShow->catalog_id, $this->_catalog);

    if($bagecmsShow->template){
      $tpl = $bagecmsShow->template;
    }elseif($catalogArr['template_show']){
       $tpl = $catalogArr['template_show'];
    }else{
        $tpl = 'show_post';
    }
    //自定义数据
    $attrVal = AttrVal::model()->findAll(array('condition'=>'post_id=:postId','with'=>'attr', 'params'=>array('postId'=>$bagecmsShow->id)));

    $tplVar = array(
        'bagecmsShow'=>$bagecmsShow,
        'attrVal'=>$attrVal,
        'catalogArr'=>$catalogArr,
        'catalogChild'=>Catalog::lite(intval( $bagecmsShow->catalog_id)),
    );
    $this->render( $tpl, $tplVar);
  }

  /**
   * 提交评论
   *
   * @return [type] [description]
   */
  public function actionPostComment() {

    $nickname = trim( $this->_gets->getParam( 'nickname' ) );
    $email = trim( $this->_gets->getParam( 'email' ) );
    $postId = trim( $this->_gets->getParam( 'postId' ) );
    $comment = trim( $this->_gets->getParam( 'comment' ) );
    try {
      if ( empty( $postId ) )
        throw new Exception( '编号丢失' );
      elseif ( empty( $nickname ) || empty( $email ) ||  empty( $comment ) )
        throw new Exception( '昵称、邮箱、内容必须填写' );
      $bagecmsPostCommentModel = new PostComment();

      $bagecmsPostCommentModel ->attributes = array(
          'post_id'=> $postId,
          'nickname'=> $nickname,
          'email'=> $email,
          'content'=> $comment,
      );

      if ( $bagecmsPostCommentModel->save() ) {
        $var['state'] = 'success';
        $var['message'] = '提交成功';
      }else {
        throw new Exception( CHtml::errorSummary( $bagecmsPostCommentModel, null, null, array ( 'firstError' => '' ) ) );
      }
      
    } catch ( Exception $e ) {
      $var['state'] = 'error';
      $var['message'] = '出现错误：'.$e->getMessage();
    }
    exit( CJSON::encode( $var ) );
  }
}
