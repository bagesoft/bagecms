<?php if (CHtml::errorSummary($model)):?>

<table  id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message"> <?php echo CHtml::errorSummary($model); ?> </span></div></td>
  </tr>
</table>
<?php endif?>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title">用户组名称：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'group_name',array('size'=>30,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <!-- <tr>
            <td  colspan="2">权限：</td>
        </tr>
        <tr >
            <td ><?php echo $form->textField($model,'acl',array('size'=>30, 'maxlength'=>50)); ?></td>
            <td class="vtop tips2"></td>
        </tr>-->
  
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
