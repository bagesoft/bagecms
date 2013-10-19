<?php echo $this->renderPartial('/_include/header')?>

<div id="contentHeader">
  <h3>程序升级</h3>
  
</div>
<form action="" method="post"  enctype="multipart/form-data" >
  <table class="content_list">
    <tr>
      <td class="td27">当前版本：BageCMS V<?php echo $this->_bagecms?></td>
    </tr>
    <tr class="noborder">
      <td class="vtop rowform">官方版本：BageCMS V</td>
    </tr>
    <tr>
      <td class="td27">&nbsp;</td>
    </tr>
    <tr class="submit">
      <td ><input type="submit" name="editsubmit" value="升级程序" class="button" tabindex="3" /></td>
    </tr>
    <tbody id="mail_smtp_auth" >
  </table>
 
</form>

<?php echo $this->renderPartial('/_include/footer')?>