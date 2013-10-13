<?php
/**
 * 系统分类
 * 
 * @author        shuguang <5565907@qq.com>
 * @copyright     Copyright (c) 2007-2013 bagesoft. All rights reserved.
 * @link          http://www.bagecms.com
 * @package       BageCMS.admini.Controller
 * @license       http://www.bagecms.com/license
 * @version       v3.1.0
 */

class CatalogController extends XAdminiBase
{
    /**
     * 首页
     */
    public function actionIndex ()
    {
        parent::_acl();
        $datalist = Catalog::get(0, $this->_catalog);
        $this->render('index', array ('datalist' => $datalist ));
    }

    /**
     * 录入
     *
     */
    public function actionCreate ()
    {
        parent::_acl();
        $model = new Catalog();
        if (isset($_POST['Catalog'])) {
            $model->attributes = $_POST['Catalog'];
            $file = XUpload::upload($_FILES['attach'], array('thumb'=>true, 'thumbSize'=>array ( 100 , 150 )) );
            if (is_array($file)) {
                $model->attach_file = $file['pathname'];
                $model->attach_thumb = $file['paththumbname'];
            }
            if ($model->save()) {
                XXcache::refresh('_catalog');
                parent::_adminiLogger(array('catalog'=>'create', 'intro'=>'录入全局分类,ID:'.$id.'名称：'.$model->catalog_name));
                $this->redirect(array ('index' ));
            }
        }
        $parentId =intval( $this->_gets->getParam('id'));
        $model->template_list = 'list_text';
        $model->template_page = 'list_page';
        $model->template_show = 'show_post';
        $this->render('create', array ('model' => $model , 'parentId' => $parentId ));
    }

    /**
     * 编辑
     *
     * @param  $id
     */
    public function actionUpdate ($id)
    {
        parent::_acl();
        $model = new Catalog();
        $parentId = intval($_POST['Catalog']['parent_id']);
        $model = parent::_dataLoad(new Catalog(), $id);
        if (isset($_POST['Catalog'])) {
            self::parentTrue($id, $parentId);
            $model->attributes = $_POST['Catalog'];
            $file = XUpload::upload($_FILES['attach'], array('thumb'=>true, 'thumbSize'=>array ( 100 , 150 )) );
            if (is_array($file)) {
                $model->attach_file = $file['pathname'];
                $model->attach_thumb = $file['paththumbname'];
                @unlink($_POST['oAttach']);
                @unlink($_POST['oThumb']);
            }
            if ($model->save()) {
                XXcache::refresh('_catalog');
                parent::_adminiLogger(array('catalog'=>'update', 'intro'=>'编辑全局分类,ID:'.$model->id.',名称：'.$model->catalog_name));
                $this->redirect(array ('index' ));
            }
        }

        $this->render('update', array ('model' => $model ));
    
    }

    /**
     * 检测上级分类是否合法
     *
     * @param  $item
     * @param  $parentId
     */
    protected function parentTrue ($item = 0, $parentId = 0)
    {
        $subCategory = Catalog::get($item, $this->_catalog);
        if (empty($subCategory)) {
            $getCategory[] = $item;
        } else {
            foreach ((array) $subCategory as $row) {
                $getCategory[] = $row['id'];
            }
            //将本身ID加入检测对象
            array_push($getCategory, $item);
        }
        if (in_array($parentId, $getCategory))
            XUtils::message('error', '所选择的上级分类不能是当前分类或者当前分类的下级分类');
    
    }

    /**
     * 批量操作
     *
     */
    public function actionBatch ()
    {
        if (XUtils::method() == 'GET') {
            $command = trim($_GET['command']);
            $ids = intval($_GET['id']);
        } else 
            if (XUtils::method() == 'POST') {
                $command = trim($_POST['command']);
                $ids = $_POST['id'];
                is_array($ids) && $ids = implode(',', $ids);
            } else {
                XUtils::message('errorBack', '只支持POST,GET数据');
            }
        
        
        switch ($command) {
            case 'delete':
                parent::_acl('catalog_delete');
                empty($ids) && XUtils::message('error', '未选择记录');
                parent::_adminiLogger(array('catalog'=>'delete', 'intro'=>'删除全局分类，ID:'.$ids));
                parent::_delete(new Catalog(), $ids, array ('index' ));
                break;
            case 'sortOrder':
                parent::_acl('catalog_sort_order');
                $sortOrder = $this->_gets->getParam('sortOrder');
                foreach((array)$sortOrder as $id=>$val){
                    $catalogModel = Catalog::model()->findByPk($id);
                    if($catalogModel){
                        $catalogModel->sort_order = $val;
                        $catalogModel->save();
                    }
                }
                $this->redirect(array('index'));
                break;
            default:
                throw new CHttpException(404, '错误的操作类型:' . $command);
                break;
        }
    
    }

}