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
    <td class="tb_title">属性名称：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'attr_name',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">属性别名(字母或数字组合)：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'attr_name_alias',array('size'=>40,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <tr>
    <td class="tb_title">属性名称说明</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'tips',array('size'=>40,'maxlength'=>128)); ?></td>
  </tr>
  <tr >
    <td class="tb_title">适用范围：<?php echo $form->dropDownList($model,'scope',XParams::$attrScope,array('onchange'=>'changeScope(this)')); ?><span id="catalogSpan" <?php if($model->scope != 'post'):?>style="display:none"<?php endif?>> 栏目归属：
      <select name="Attr[catalog_id]" >
        <option value="0">==选择栏目==</option>
        <?php foreach((array)Catalog::get(0, $this->_catalog) as $catalog):?>
        <option value="<?php echo $catalog['id']?>" <?php XUtils::selected($catalog['id'], $model->catalog_id);?>><?php echo $catalog['str_repeat']?><?php echo $catalog['catalog_name']?></option>
        <?php endforeach;?>
      </select>
      </span></td>
  </tr>
  <tr>
    <td class="tb_title">属性类型</td>
  </tr>
  <tr >
    <td ><?php echo $form->dropDownList($model,'attr_type', XParams::$attrItemType); ?></td>
  </tr>
  <tr>
    <td class="tb_title">字段提示信息</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'tips',array('size'=>40,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title">属性默认数据</td>
  </tr>
  <tr >
    <td ><?php echo $form->textArea($model,'data_default',array('rows'=>5,'cols'=>70,'maxlength'=>128)); ?></td>
  </tr>
  <tr class="submit">
    <td ><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
  </tr>
</table>
<script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});

function changeScope(ths){
	if(ths.value == 'post'){
		$("#catalogSpan").show();
	}else{
		$("#catalogSpan").hide();
	}
}
</script>
<?php $form=$this->endWidget(); ?>
