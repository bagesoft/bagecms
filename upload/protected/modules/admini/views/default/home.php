<?php $this->renderPartial('/_include/header');?>

<table class="content_list">
 <thead>  <tr >
    <td >备忘录(记录未完成或待办事宜)<span id="notebookMessage"></span></td>
  </tr>
   </thead>
  <tr>
    <td><textarea name="notebook" cols="80" rows="6" id="notebook" onblur="updateNotebook()" > <?php echo $notebook->notebook?></textarea></td>
  </tr>
</table>
<table class="content_list">
  <thead>
    <tr >
      <td colspan="2" class="tbTitle">系统信息</td>
    </tr>
  </thead>
  <tr>
    <td width="100" >程序版本</td>
    <td ><?php echo $this->_bagecms?> <?php echo $this->_bagecmsRelease?></td>
  </tr>
  <tr>
    <td >最新版本</td>
    <td ><span id="bagesoftVersion"></span></td>
  </tr>
  <tr>
    <td >产品支持</td>
    <td ><a href="http://www.bagecms.com" target="_blank">www.bagecms.com </a><a href="http://www.bagecms.com/help" target="_blank">使用手册</a></td>
  </tr>
  <tr>
    <td >操作系统软件</td>
    <td ><?php echo $server['serverOs']?> - <?php echo $server['serverSoft']?></td>
  </tr>
  <tr>
    <td >数据库及大小</td>
    <td ><?php echo $server['mysqlVersion']?> (<?php echo $server['dbsize']?>)</td>
  </tr>
  <tr>
    <td >上传许可</td>
    <td ><?php echo $server['fileupload']?></td>
  </tr>
  <tr>
    <td >主机名</td>
    <td ><?php echo $server['serverUri']?></td>
  </tr>
  <tr>
    <td >当前使用内存</td>
    <td ><?php echo $server['excuteUseMemory']?></td>
  </tr>
  <tr>
    <td >PHP环境</td>
    <td >magic_quote_gpc:<?php echo $server['magic_quote_gpc']?> allow_url_fopen:<?php echo $server['allow_url_fopen']?></td>
  </tr>
</table>
<script language="javascript"> 
<!-- 
function updateNotebook()
{
  $("#notebookMessage").fadeIn(2000);
  $("#notebookMessage").html('<span style="color:#FF0000"><img src="<?php echo $this->_baseUrl?>/static/admin/images/loading.gif" align="absmiddle">正在更新数据...</span>'); 
  $.post("<?php echo $this->createUrl('notebookUpdate')?>",{notebook:$('#notebook').val()},function(response){
      if(response.state == 'success'){
          $("#notebookMessage").html('<span style="color:#FF0000">'+response.message+'</span>'); 
      }else{
          alert(response.message);
      }
      $("#notebookMessage").fadeOut(2000);  
  }, 'json');

}
//--> 
</script>
<!--检测系统最新版本及安全补丁-->
<script language="javascript" src="http://www.bagesoft.cn/upgrade/version?text=<?php echo $env?>" charset="UTF-8"></script>
<?php $this->renderPartial('/_include/footer');?>
