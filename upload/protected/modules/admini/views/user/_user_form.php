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
    <td class="tb_title">用户：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'username',array('size'=>30,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">密码：</td>
  </tr>
  <tr >
    <td ><?php if($model->isNewRecord):?>
      <?php echo $form->textField($model,'password',array('size'=>30, 'maxlength'=>50, 'value'=>'', 'class'=>'validate[required]')); ?>
      <?php else:?>
      <?php echo $form->textField($model,'password',array('size'=>30, 'maxlength'=>50, 'value'=>'')); ?>
      <?php endif?></td>
  </tr>
  <tr>
    <td class="tb_title">邮箱：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'email',array('size'=>30, 'maxlength'=>50)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">用户组：</td>
  </tr>
  <tr >
    <td ><select name="Project[catalog_id]">
        <?php foreach((array)$this->group_list as $group):?>
        <option value="<?php echo $group['id']?>" <?php XUtils::selected($group['id'], $model->group_id);?>><?php echo $group['group_name']?></option>
        <?php endforeach;?>
      </select></td>
  </tr>
  <tr>
    <td class="tb_title">真实姓名：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'realname',array('size'=>30,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">MSN：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'msn',array('size'=>30,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">QQ：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'qq',array('size'=>30,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">sex：</td>
  </tr>
  <tr >
    <td class="tb_title"><input type="radio" name="User[sex]" id="radio" value="男" <?php XUtils::selected('男', $model->sex, 'checked')?>/>
      男
      <input type="radio" name="User[sex]" id="radio" value="女" <?php XUtils::selected('女', $model->sex, 'checked')?>/>
      女 </td>
  </tr>
  <tr>
    <td class="tb_title">工作单位：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'work_company',array('size'=>30,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">地区：</td>
  </tr>
  <tr >
    <td ><script src="<?php echo $this->_baseUrl ?>/static/js/pca.min.js" type="text/javascript"></script>
      <select id="User_province" name="User[province]">
      </select>
      <select id="User_city" name="User[city]">
      </select>
      <select id="User_area" name="User[area]" style="display:none">
      </select>
      <script type="text/javascript" language="javascript">
new PCAS("User[province]","User[city]","<?php echo $model->province ?>","<?php echo $model->city?>")
</script></td>
  </tr>
  <tr>
    <td class="tb_title">网址：</td>
  </tr>
  <tr >
    <td class="tb_title"><?php echo $form->textField($model,'http_url',array('size'=>30,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">个人简介：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textArea($model,'intro',array('rows'=>4, 'cols'=>70)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">注册ip：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'register_ip',array('size'=>30,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">最后登录时间：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'last_login_time',array('size'=>30,'maxlength'=>128,'class'=>'Wdate', 'onClick'=>'WdatePicker({dateFmt:"yyyy-MM-dd"})')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">最后登录IP：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'last_login_ip',array('size'=>30,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">登录次数：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'login_count',array('size'=>5,'maxlength'=>10)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">状态：</td>
  </tr>
  <tr >
    <td ><?php echo $form->dropDownList($model,'status_is',array('active'=>'正常', 'locker'=>'锁定')); ?></td>
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
