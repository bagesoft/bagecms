<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>模板管理</h3>
  
</div>
<script type="text/javascript">
$(function(){
	
	$("#folderCreate").click(function(){
		var folderName = $("#folderName").val();
		if(folderName == ''){
			alert('文件夹名称必须填写');
			return ;
		}
		$.post("<?php echo $this->createUrl('folderCreate')?>",{folder:folderName},function(res){
			alert(res.message);
			if(res.state == 'success'){
				window.location.reload();
			}
		},'json')
	});
		
});

</script>
<div style="padding:10px 0">
  <input name="folderName" type="text" id="folderName" />
  <input name="submit" type="button" id="folderCreate" value="创建新文件夹" class="button"/>
</div>
<table class="content_list">
  <form method="post" action="<?php echo $this->createUrl('batch',array('command'=>'delete'))?>" name="cpform" >
    <tr class="tb_header">
      <th width="30%">名称</th>
      <th>操作</th>
    </tr>
    <?php foreach ((array)$fileList as $row):?>
    <tr class="tb_list">
      <td class="tb_title"><img src="<?php echo $this->_baseUrl?>/static/admin/images/folder.gif" align="absmiddle" /> <?php echo $row['fileName']?></td>
      <td ><a href="<?php echo  $this->createUrl('createTpl',array('folderName'=>$row['fileName']))?>"><img src="<?php echo $this->_baseUrl?>/static/admin/images/create.gif" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo  $this->createUrl('batch',array('command'=>'deleteFolder', 'folderName'=>$row['fileName']))?>" class="confirmSubmit"><img src="<?php echo $this->_baseUrl?>/static/admin/images/delete.png" align="absmiddle" /></a></td>
    </tr>
    <?php foreach ((array)$row['subFileList'] as $subrow):?>
    <tr class="tb_list">
      <td style="padding:0 0 0 20px"><?php echo $subrow?></td>
      <td ><a href="<?php echo  $this->createUrl('updateTpl',array('filename'=>XUtils::b64encode($row['fileName'].'/'.$subrow)))?>"><img src="<?php echo $this->_baseUrl?>/static/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo  $this->createUrl('batch',array('command'=>'deleteFile', 'fileName'=>XUtils::b64encode($row['fileName'].'/'.$subrow)))?>" class="confirmSubmit"><img src="<?php echo $this->_baseUrl?>/static/admin/images/delete.png" align="absmiddle" /></a></td>
    </tr>
    <?php endforeach;?>
    <?php endforeach;?>
  </form>
</table>
<?php $this->renderPartial('/_include/footer');?>
