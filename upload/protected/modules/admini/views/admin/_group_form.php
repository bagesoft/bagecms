<?php if (CHtml::errorSummary($model)):?>

<table id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message">
       <?php echo CHtml::errorSummary($model); ?>
        </span></div></td>
  </tr>
</table>
<?php endif?>
<script type="text/javascript">
    function checknode(obj) {
        var chk = $("input[type='checkbox']");
        var count = chk.length;
        var num = chk.index(obj);
        var level_top = level_bottom = chk.eq(num).attr('level');
		for (var i = num; i >= 0; i--) {
            var le = chk.eq(i).attr('level');
            if (eval(le) < eval(level_top)) {
                chk.eq(i).attr("checked", true);
                var level_top = level_top - 1
            }
        }
        for (var j = num + 1; j < count; j++) {
            var le = chk.eq(j).attr('level');
            if (chk.eq(num).attr("checked") == true) {
                if (eval(le) > eval(level_bottom)) chk.eq(j).attr("checked", true);
                else if (eval(le) == eval(level_bottom)) break
            } else {
                if (eval(le) > eval(level_bottom)) chk.eq(j).attr("checked", false);
                else if (eval(le) == eval(level_bottom)) break
            }
        }
    }
</script>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform'))); ?>
<table class="form_table">
  <tr>
    <td  colspan="2" class="tb_title">用户组名称：</td>
  </tr>
  <tr >
    <td colspan="2" ><?php echo $form->textField($model,'group_name',array('size'=>50,'maxlength'=>128, 'class'=>'validate[required]')); ?></td>
  </tr>
  <?php $i = 0; foreach((array)XAdminiAcl::$aclList as $key=>$menu):?>
  <tr>
    <td  colspan="2"><?php if($menu['controller'] !='home'):?>
      <input name="acl[]" type="checkbox" value="<?php echo $menu['controller'] ?>" <?php if(in_array($menu['controller'], explode(',', $model->acl))): ?>checked="checked"<?php endif ?> level='0' onclick='javascript:checknode(this);'/>
      <?php endif?>
      <?php echo $key ?></td>
  </tr>
  <?php foreach((array)$menu['action'] as $k=>$module):?>
  <?php if($module['name'] != '首页'):?>
  <tr >
    <td  width="17%" >　　　　　
      <input name="acl[]" type="checkbox" value="<?php echo $module['acl'] ?>" <?php if(in_array($module['acl'], explode(',', $model->acl))): ?>checked="checked"<?php endif ?> level='1' onclick='javascript:checknode(this);'/>
      <?php echo $module['name']?></td>
    <td class="vtop tips2"><?php foreach((array)$module['list_acl'] as $aclName=>$acl):?>
      <input name="acl[]" type="checkbox" value="<?php echo $acl ?>" <?php if(in_array($acl, explode(',', $model->acl))): ?>checked="checked"<?php endif ?> level='2' onclick='javascript:checknode(this);'/>
      <?php echo $aclName?>
      <?php endforeach; ?></td>
  </tr>
  <?php endif?>
  <?php endforeach; ?>
  <?php $i++;endforeach;?>
  <tr class="submit">
      <td colspan="2" ><input type="checkbox" name="chkall" id="chkall" onClick="checkAll(this.form, 'acl')" />
  <label for="chkall">全选</label></td> 
  </tr>
   <tr class="submit">
      <td colspan="2"><input name="submit" type="submit" id="submit" value="提交" class="button" /></td>
    </tr>
</table>


<script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script>
<?php $form=$this->endWidget(); ?>
