<?php if (CHtml::errorSummary($model)):?>

<table id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message"> <?php echo CHtml::errorSummary($model); ?> </span></div></td>
  </tr>
</table>
<?php endif?>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title">模板名称：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'title',array('size'=>50,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">发送标题：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'send_title',array('size'=>50,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">模板标识：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'link_label',array('size'=>30,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">文本内容：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textArea($model,'content_txt', array('cols'=>80, 'rows'=>'10')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">HTML内容：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textArea($model,'content_html', array('cols'=>80, 'rows'=>'10')); ?></td>
  </tr>
  <tr class="submit">
    <td ><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
  </tr>
</table>
<script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script>
<?php $form=$this->endWidget(); ?>
