<?php
/**
 * 问答
 *
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class QuestionController extends XFrontBase
{
    /**
     * 首页
     */
    public function actionIndex() {

        $bagecmsQuestionModel = new Question();
        $bagecmsQuestionCriteria = new CDbCriteria();
        $bagecmsQuestionCriteria->condition = 'status_is=:status';
        $bagecmsQuestionCriteria->params = array( 'status'=>'Y' );
        $bagecmsQuestionCriteria->order = 't.id DESC';
        $bagecmsQuestionCount = $bagecmsQuestionModel->count( $bagecmsQuestionCriteria );
        $bagecmsQuestionPages = new CPagination( $bagecmsQuestionCount );
        $bagecmsQuestionPages->pageSize = 10;
        $bagecmsQuestionPageParams = XUtils::buildCondition( $_GET, array () );
        $bagecmsQuestionPageParams['#'] = 'list';
        $bagecmsQuestionPages->params = is_array( $bagecmsQuestionPageParams ) ? $bagecmsQuestionPageParams : array ();
        $bagecmsQuestionCriteria->limit = $bagecmsQuestionPages->pageSize;
        $bagecmsQuestionCriteria->offset = $bagecmsQuestionPages->currentPage * $bagecmsQuestionPages->pageSize;
        $bagecmsQuestionList = $bagecmsQuestionModel->findAll( $bagecmsQuestionCriteria );
        $this->_seoTitle = '留言咨询 - '.$this->_conf['site_name'];
        $this->render( 'index', array( 'bagecmsQuestionList'=>$bagecmsQuestionList, 'pages'=>$bagecmsQuestionPages ) );
    }

    /**
     * 提交留言
     */
    public function actionPost() {
        if ( $_POST['Question'] ) {
            try {
                $questionModel = new Question();
                $questionModel->attributes = $_POST['Question'];
                if ( $questionModel->save() ) {
                    $var['state'] = 'success';
                    $var['message'] = '提交成功';
                }else {
                    throw new Exception( CHtml::errorSummary( $questionModel, null, null, array ( 'firstError' => '' ) ) );
                }
            } catch ( Exception $e ) {
                $var['state'] = 'error';
                $var['message'] = $e->getMessage();
            }
        }
        exit( CJSON::encode( $var ) );
    }
}
