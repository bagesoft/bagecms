<?php $form = $this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform', 'enctype'=>'multipart/form-data'))); ?>

<table class="form_table">
  <?php if($this->action->id == 'createTpl'):?>
  <tr>
    <td class="tb_title">文件名称：</td>
  </tr>
  <tr >
    <td ><input name="fileName" type="text" id="fileName" size="50" />
      .php</td>
  </tr>
  <tr>
    <td class="tb_title">文件夹：</td>
  </tr>
  <tr >
    <td ><?php echo $folderName?></td>
  </tr>
  <?php else:?>
  <tr>
    <td class="tb_title">文件名称：</td>
  </tr>
  <tr >
    <td ><?php echo $filename?></td>
  </tr>
  <?php endif?>
  <tr>
    <td class="tb_title">SEO描述：</td>
  </tr>
  <tr >
    <td ><label for="content"></label>
      <textarea name="content" id="content" rows="5" style="width:90%; height:400px"><?php echo $content?></textarea></td>
  </tr>
  <tr class="submit">
    <td ><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
  </tr>
</table>
<?php $form=$this->endWidget(); ?>
