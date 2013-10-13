<?php if (CHtml::errorSummary($model)):?>

<table id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message"> <?php echo CHtml::errorSummary($model); ?> </span></div></td>
  </tr>
</table>
<?php endif?>
<script type="text/javascript">
$(function(){
  $("#Catalog_parent_id").val(<?php echo $parentId ?>);
});
</script>
<?php $form = $this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform', 'enctype'=>'multipart/form-data'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title">名称：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'catalog_name',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">名称别名：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'catalog_name_second',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">唯一标识(英文字母或数字组合)：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'catalog_name_alias',array('size'=>40,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">所属分类：</td>
  </tr>
  <tr >
    <td ><select name="Catalog[parent_id]" id="Catalog_parent_id">
        <option value="0">==顶级分类==</option>
        <?php foreach((array)Catalog::get(0, $this->_catalog) as $catalog):?>
        <option value="<?php echo $catalog['id']?>" <?php XUtils::selected($catalog['id'], $model->parent_id);?>><?php echo $catalog['str_repeat']?><?php echo $catalog['catalog_name']?></option>
        <?php endforeach;?>
      </select></td>
  </tr>
  <tr>
    <td class="tb_title">显示方式：</td>
  </tr>
  <tr >
    <td class="tb_title"><?php echo $form->dropDownList($model,'display_type',array('list'=>'列表', 'page'=>'单页')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">每页显示数量(0或空表示默认20条)：</td>
  </tr>
  <tr >
    <td class="tb_title"><?php echo $form->textField($model,'page_size',array('size'=>5,'maxlength'=>5)); ?></td>
  </tr>
  
  <tr>
    <td class="tb_title">列表模板：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'template_list',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">单页模板：</td>
  </tr>
  
  <tr >
    <td ><?php echo $form->textField($model,'template_page',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">内容页模板：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'template_show',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">跳转地址：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'redirect_url',array('size'=>60,'maxlength'=>128)); ?> 若填写此地址则直接跳转到链接地址</td>
  </tr>
  <tr>
    <td class="tb_title">封面图片：</td>
  </tr>
  <tr >
    <td ><input name="attach" type="file" id="attach" />
      <?php if ($model->attach_file):?>
      <a href="<?php echo $this->_baseUrl.'/'. $model->attach_file?>" target="_blank"><img src="<?php echo $this->_baseUrl.'/'. $model->attach_file?>" width="50" align="absmiddle" /></a>
      <?php endif?></td>
  </tr>
  <tr>
    <td class="tb_title">栏目介绍：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textArea($model,'content'); ?>
      <?php $this->widget('application.widget.kindeditor.KindEditor',array('target'=>array(
'#Catalog_content'=>array('uploadJson'=> $this->createUrl('upload')))));?></td>
  </tr>
  <tr>
    <td class="tb_title">SEO标题：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'seo_title',array('size'=>50,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">SEO关键字：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'seo_keywords',array('size'=>50,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">SEO描述：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textArea($model,'seo_description',array('rows'=>5,'cols'=>80)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">状态：</td>
  </tr>
  <tr >
    <td ><?php echo $form->dropDownList($model,'status_is',array('Y'=>'显示', 'N'=>'隐藏')); ?>排序:<?php echo $form->textField($model,'sort_order',array('size'=>6,'maxlength'=>128)); ?></td>
  </tr>
  <tr class="submit">
    <td ><input name="oAttach" type="hidden" value="<?php echo $model->attach_file ?>" />
      <input name="oThumb" type="hidden" value="<?php echo $model->attach_thumb ?>" />
      <input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
  </tr>
</table>
<script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script>
<?php $form=$this->endWidget(); ?>
