<?php echo $this->renderPartial('/_include/header')?>

<div id="contentHeader">
  <h3>会员设置</h3>
  
</div>
<form action="" method="post"  enctype="multipart/form-data" >
  <table class="content_list">
    <tr>
      <td class="tb_title">会员功能：</td>
    </tr>
    <tr >
      <td ><select name="Config[user_status]">
          <option value="open" <?php echo XUtils::selected($config['user_status'], 'open')?>>开启会员功能</option>
          <option value="close" <?php echo XUtils::selected($config['user_status'], 'close')?>>关闭会员功能</option>
        </select>
        如关闭，则网站不再允许使用相关会员所有功能 </td>
    </tr>
    <tr>
      <td class="tb_title">邮箱验证激活：</td>
    </tr>
    <tr >
      <td ><select name="Config[user_mail_verify]">
          <option value="open" <?php echo XUtils::selected($config['user_mail_verify'], 'open')?>>开启会员邮件验证</option>
          <option value="close" <?php echo XUtils::selected($config['user_mail_verify'], 'close')?>>禁用会员邮件验证 </option>
        </select></td>
    </tr>
    <tr>
      <td class="tb_title">不允许注册用户名：</td>
    </tr>
    <tr >
      <td ><input type="text" class="txt w400" name="Config[user_name_disable]" value="<?php echo $config['user_name_disable']?>" /></td>
    </tr>
    <tr>
      <td class="tb_title">会员审核：</td>
    </tr>
    <tr >
      <td ><select name="Config[user_verify]">
          <option value="open" <?php echo XUtils::selected($config['user_verify'], 'open')?>>审核后才能登录</option>
          <option value="close" <?php echo XUtils::selected($config['user_verify'], 'close')?>>不需要审核</option>
        </select></td>
    </tr>
    <tr class="submit">
      <td ><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
    </tr>
  </table>
</form>

<?php echo $this->renderPartial('/_include/footer')?>