<?php echo $this->renderPartial('/_include/header')?>

<div id="contentHeader">
  <h3>SEO配置</h3>
  
</div>
<form action="" method="post"  enctype="multipart/form-data" >
  <table class="content_list">
    <tr>
      <td class="tb_title">网站标题：</td>
    </tr>
    <tr >
      <td ><input type="text" class="txt" name="Config[seo_title]" value="<?php echo $config['seo_title']?>" /></td>
    </tr>
    <tr>
      <td class="tb_title">网站关键字：</td>
    </tr>
    <tr >
      <td ><input type="text" class="txt" name="Config[seo_keywords]" value="<?php echo $config['seo_keywords']?>"/></td>
    </tr>
    <tr>
      <td class="tb_title">网站描述：</td>
    </tr>
    <tr >
      <td ><textarea  rows="6" name="Config[seo_description]" id="seo_description" cols="50" class="tarea middenWidth"><?php echo $config['seo_description']?></textarea>
        </span></td>
    </tr>
    <tr class="submit">
      <td ><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
    </tr>
  </table>
</form>

<?php echo $this->renderPartial('/_include/footer')?>