<?php echo $this->renderPartial('/_include/header')?>

<div id="contentHeader">
  <h3>短信配置</h3>
  
</div>
<form action="" method="post"  enctype="multipart/form-data" >
  <table class="content_list">
    <tr>
      <td class="tb_title">接口类型：</td>
    </tr>
    <tr >
      <td ><select name="Config[sms_service]">
          <option value="winic">WINIC - www.winic.com</option>
          <option value="zgsj">中国数据 - www.zgsj.com</option>
        </select>
        <span info="Config[sms_server]"></span></td>
    </tr>
    <tr>
      <td class="tb_title">短信服务器地址：</td>
    </tr>
    <tr >
      <td ><input name="Config[sms_server]" type="text" class="midWidth txt" value="<?php echo $config['sms_server']?>" datatype="Require" msg="请填写短信服务器地址"/>
        <span info="Config[sms_server]"></span></td>
    </tr>
    <tbody id="mail_smtp_auth" >
      <tr>
        <td class="tb_title">用户名：</td>
      </tr>
      <tr >
        <td ><input type="text" class="txt" name="Config[sms_user]" value="<?php echo $config['sms_user']?>" datatype="Require" msg="请填写短信用户名"/></td>
      </tr>
      <tr>
        <td class="tb_title">密码：</td>
      </tr>
      <tr >
        <td ><input type="text" class="txt" name="Config[sms_password]" value="<?php echo $config['sms_password']?>" datatype="Require" msg="请填写短信密码"/></td>
      </tr>
      <tr class="submit">
        <td ><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
      </tr>
  </table>
</form>

<?php echo $this->renderPartial('/_include/footer')?>