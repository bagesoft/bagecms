<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>附件</h3>
  <div class="searchArea">
    <ul class="action left" >
    </ul>
    <div class="search right">
      <?php $form = $this->beginWidget('CActiveForm',array('id'=>'searchForm','method'=>'get','action'=>array('attach'),'htmlOptions'=>array('name'=>'xform'))); ?>
      原始名称
      <input id="filename" type="text" name="filename" value="" class="txt" size="15"/>
      文件名称
      <input id="realname" type="text" name="realname" value="" class="txt" size="15"/>
      <input name="searchsubmit" type="submit" value="查询" class="button"/>
      <script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script>
      <?php $form=$this->endWidget(); ?>
      <script type="text/javascript">
$(document).ready(function(){
	$("#file_name").val('<?php echo Yii::app()->request->getParam('file_name')?>');
	$("#nickname").val('<?php echo Yii::app()->request->getParam('nickname')?>');
});
</script> </div>
  </div>
</div>
<table class="content_list">
  <form method="post" action="<?php echo $this->createUrl('batch')?>" name="cpform" >
    <tr class="tb_header">
      <th width="8%">ID</th>
      <th width="20%">图片</th>
      <th>原始名称</th>
      <!--<th width="15%">用户</th>-->
      
      <th width="10%">大小</th>
      <th width="15%">录入时间</th>
      <th width="8%">操作</th>
    </tr>
    <?php foreach ($datalist as $row):?>
    <tr class="tb_list">
      <td ><input type="checkbox" name="id[]" value="<?php echo $row->id?>">
        <?php echo $row->id?></td>
      <td ><a href="<?php echo $row->file_name?>" target="_blank"><img src="<?php echo $row->file_name?>" alt="<?php echo $row->real_name?>" width="70" title="<?php echo $row->real_name?>"/></a></td>
      <td ><p><?php echo $row->real_name?></p>
        <p><?php echo $row->save_path?></p>
        <p><?php echo $row->save_name?></p></td>
      <!--<td ></td>-->
      
      <td ><span ><?php echo XUtils::byteFormat($row->file_size)?></span></td>
      <td ><?php echo date('Y-m-d H:i',$row->create_time)?></td>
      <td ><a href="<?php echo  $this->createUrl('batch',array('command'=>'attachDelete', 'id'=>$row->id))?>" class="confirmSubmit"><img src="<?php echo $this->_baseUrl?>/static/admin/images/delete.png" align="absmiddle" /></a></td>
    </tr>
    <?php endforeach;?>
    <tr class="submit">
      <td colspan="9"><div class="cuspages right">
          <?php $this->widget('CLinkPager',array('pages'=>$pagebar));?>
        </div>
        <div class="fixsel" >
          <input type="checkbox" name="chkall" id="chkall" onclick="checkAll(this.form, 'id')" />
          <label for="chkall">全选</label>
          <select name="command">
            <option>选择操作</option>
            <option value="attachDelete">删除</option>
          </select>
          <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
        </div></td>
    </tr>
  </form>
</table>
<?php $this->renderPartial('/_include/footer');?>
