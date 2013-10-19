<?php if (CHtml::errorSummary($model)):?>
<table id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message"> <?php echo CHtml::errorSummary($model); ?> </span></div></td>
  </tr>
</table>
<?php endif?>
<?php $form = $this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform','enctype'=>'multipart/form-data'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title">网站名称：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'site_name',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">网站 URL：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'site_url',array('size'=>60,'maxlength'=>128, 'class'=>'validate[required,custom[url]]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">图片：
      <?php if($model->link_type == 'image'):?>
      <input name="remove" type="checkbox" value="Y" id="remove" />
      转为文本链接
      <?php endif?></td>
  </tr>
  <tr >
    <td ><input name="attach" type="file" id="attach" />
      <?php if ($model->attach_file):?>
      <a href="<?php echo $this->_baseUrl.'/'. $model->attach_file?>" target="_blank"><img src="<?php echo $this->_baseUrl.'/'. $model->attach_file?>" width="50" align="absmiddle" /></a>
      <?php endif?></td>
  </tr>
  <tr>
    <td class="tb_title">排序：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'sort_order',array('size'=>5,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">显示状态：</td>
  </tr>
  <tr >
    <td ><?php echo $form->dropDownList($model,'status_is',array('Y'=>'是', 'N'=>'否')); ?></td>
  </tr>
  <tr class="submit">
    <td ><input name="oAttach" type="hidden" value="<?php echo $model->attach_file ?>" />
      <input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
  </tr>
</table>
<script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script>
<?php $form=$this->endWidget(); ?>
