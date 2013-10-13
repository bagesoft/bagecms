<?php $form=$this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform'))); ?>

<table class="form_table">
  <tr>
    <td class="tb_title">登录接口：</td>
  </tr>
  <tr >
    <td  style="width:100px"><?php echo $model->api?></td>
  </tr>
  <tr>
    <td class="tb_title">接口返回ID：</td>
  </tr>
  <tr >
    <td  ><?php echo $model->api_uid?></td>
  </tr>
  <tr>
    <td class="tb_title">平台用户：</td>
  </tr>
  <tr >
    <td  ><?php echo $model->user->username?></td>
  </tr>
  <tr>
    <td class="tb_title">访问令牌：</td>
  </tr>
  <tr >
    <td  class="tb_title"><?php echo $model->access_token?></td>
  </tr>
  <tr>
    <td class="tb_title">令牌刷新方式：</td>
  </tr>
  <tr >
    <td  ><?php echo $model->refresh_token?></td>
  </tr>
  <tr>
    <td class="tb_title">绑定时间：</td>
  </tr>
  <tr >
    <td ><?php echo date('Y-m-d H:i:s',$model->create_time)?></td>
  </tr>
</table>
<!--<div class="opt">
  <input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" />
</div>--> 
<script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script>
<?php $form=$this->endWidget(); ?>
