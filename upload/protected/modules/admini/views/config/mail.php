<?php echo $this->renderPartial('/_include/header')?>

<div id="contentHeader">
  <h3>邮件配置</h3>
  
</div>
<form action="" method="post"  enctype="multipart/form-data" id="mailConfig">
  <table class="content_list">
    <tr>
      <td class="tb_title">SMTP 服务器地址：</td>
    </tr>
    <tr >
      <td ><input type="text" class="txt" name="Config[smtp_server]" value="<?php echo $config['smtp_server']?>" />
        <span info="Config[smtp_server]"></span></td>
    </tr>
    <tr>
      <td class="tb_title">SMTP 服务器端口：</td>
    </tr>
    <tr >
      <td ><input type="text" class="txt" name="Config[smtp_port]" value="<?php echo $config['smtp_port']?>" />
        <span info="Config[smtp_port]"></span></td>
    </tr>
    <tr>
      <td class="tb_title">发信人邮件地址：</td>
    </tr>
    <tr >
      <td ><input type="text" class="txt" name="Config[sender]" value="<?php echo $config['sender']?>" />
        <span info="Config[sender]"></span></td>
    </tr>
    <tr>
      <td class="tb_title">是否需要验证：</td>
    </tr>
    <tr >
      <td ><label>
          <input type="radio" class="radio" name="Config[smtp_auth]"  value="1"  onclick="showObj('mail_smtp_auth');"  <?php echo XUtils::selected($config['smtp_auth'], 1, 'checked')?>/>
          是</label>
        <label>
          <input type="radio" class="radio" name="Config[smtp_auth]" value="0"  onclick="hideObj('mail_smtp_auth');" <?php echo XUtils::selected($config['smtp_auth'], 0, 'checked')?>/>
          否</label></td>
    </tr>
    <tbody id="mail_smtp_auth" >
      <tr>
        <td class="tb_title">SMTP 身份验证用户名：</td>
      </tr>
      <tr >
        <td ><input type="text" class="txt" name="Config[smtp_user]" value="<?php echo $config['smtp_user']?>"/></td>
      </tr>
      <tr>
        <td class="tb_title">SMTP 身份验证密码：</td>
      </tr>
      <tr >
        <td ><input type="password" class="txt" name="Config[smtp_password]" value="<?php echo $config['smtp_password']?>"/></td>
      </tr>
      <tr class="submit">
        <td ><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" />
          &nbsp;&nbsp;&nbsp;
          <input type="button" name="mailtest" value="测试发送" class="button" tabindex="3" id="mailtest" /></td>
      </tr>
  </table>
</form>

<script type="text/javascript">
$("#mailtest").click(function(){
	$.post("<?php echo $this->createUrl('ajax/mailTest')?>",$("#mailConfig").serializeArray(),function(res){
		alert(res.state);
	},'json');	
});
</script> 
<?php echo $this->renderPartial('/_include/footer')?>