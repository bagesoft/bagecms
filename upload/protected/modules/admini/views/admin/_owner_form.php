<?php if (CHtml::errorSummary($model)):?>

<table id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message">
       <?php echo CHtml::errorSummary($model); ?>
        </span></div></td>
  </tr>
</table>
<?php endif?>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title">用户：</td>
  </tr>
  <tr >
    <td ><?php if ($model->isNewRecord):?>
      <?php echo $form->textField($model,'username',array('size'=>30,'maxlength'=>128, 'class'=>'validate[required]')); ?>
      <?php else:?>
      <?php echo $model->username?>
      <?php endif?></td>
  </tr>
  <tr>
    <td class="tb_title">密码：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'password',array('size'=>30, 'maxlength'=>50, 'value'=>'')); ?>留空为不修改密码</td>
  </tr>
  <tr>
    <td class="tb_title">邮箱：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'email',array('size'=>30, 'maxlength'=>50)); ?></td>
  </tr>
 
  <tr>
    <td class="tb_title">最后登录时间：</td>
  </tr>
  <tr >
    <td ><?php echo date('Y-m-d H:i:s', $model->last_login_time) ?></td>
  </tr>
  <tr>
    <td class="tb_title">最后登录IP：</td>
  </tr>
  <tr >
    <td ><?php echo $model->last_login_ip ?></td>
  </tr>
  <tr>
    <td class="tb_title">登录次数：</td>
  </tr>
  <tr >
    <td ><?php echo $model->login_count ?></td>
  </tr>
   <tr class="submit">
      <td > <input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
    </tr>
</table>
<script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script>
<?php $form=$this->endWidget(); ?>
