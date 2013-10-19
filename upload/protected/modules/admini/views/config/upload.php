<?php echo $this->renderPartial('/_include/header')?>

<div id="contentHeader">
  <h3>上传设置</h3>
  
</div>
<form action="" method="post"  enctype="multipart/form-data" name="xform" id="xform">
  <table class="content_list">
    <tr>
      <td class="tb_title">允许上传大小：</td>
    </tr>
    <tr >
      <td ><input name="Config[upload_max_size]" type="text" class=" validate[required]" value="<?php echo $config['upload_max_size']?>" size="10" />
        KB</td>
    </tr>
    <tr>
      <td class="tb_title">允许附件类型：</td>
    </tr>
    <tr >
      <td ><input type="text" class="txt validate[required]" name="Config[upload_allow_ext]" value="<?php echo $config['upload_allow_ext']?>"/></td>
    </tr>
    <tr>
      <td class="tb_title">水印开关：</td>
    </tr>
    <tr >
      <td ><select name="Config[upload_water_status]">
          <option value="open" <?php echo XUtils::selected($config['upload_water_status'], 'open')?>>开启</option>
          <option value="close" <?php echo XUtils::selected($config['upload_water_status'], 'close')?>>关闭</option>
        </select></td>
    </tr>
    <tr>
      <td class="tb_title">水印文件：</td>
    </tr>
    <tr >
      <td ><input type="text" class="txt" name="Config[upload_water_file]" value="<?php echo $config['upload_water_file']?>"/>
        <br />
        默认位置：static/water.gif</td>
    </tr>
    <!--<tr>
        <td class="tb_title">图片范围 upload_water_scope：</td>
      </tr>
      <tr >
        <td ><input type="text" class="txt w100" name="Config[upload_water_scope]" value="<?php echo $config['upload_water_scope']?>" datatype="Require" msg="必须填写"/><span info="Config[upload_water_scope]"></span><br />
	 大于此尺寸的图片才会被打上水印</td>
      </tr>
      
      
      <tr>
      <td class="tb_title">水印位置 upload_water_position：</td>
    </tr>
    <tr >
      <td ><select name="Config[upload_water_position]"> 
      <option value="5" <?php echo XUtils::selected($config['upload_water_position'], '5')?>>随机</option>
	    <option value="0" <?php echo XUtils::selected($config['upload_water_position'], '0')?>>右下</option>
	    <option value="3" <?php echo XUtils::selected($config['upload_water_position'], '3')?>>右上</option>
	    <option value="1" <?php echo XUtils::selected($config['upload_water_position'], '1')?>>左上</option>
	    <option value="2" <?php echo XUtils::selected($config['upload_water_position'], '2')?>>左下</option>
	    <option value="4" <?php echo XUtils::selected($config['upload_water_position'], '4')?>>中间</option>
      </select>
     
     
        </td>
    </tr>
      <tr>
        <td class="tb_title">水印边距 upload_water_padding / upload_water_padding：</td>
      </tr>
      <tr >
        <td ><input type="text" class="txt w100" name="Config[upload_water_padding]" value="<?php echo $config['upload_water_padding']?>" datatype="Require" msg="必须填写"/>像素(px)<span info="Config[upload_water_padding]"></span></td>
      </tr>-->
    
    <tr>
      <td class="tb_title">水印透明度：</td>
    </tr>
    <tr >
      <td ><input type="text" class="txt w100" name="Config[upload_water_trans]" value="<?php echo $config['upload_water_trans']?>" datatype="Require" msg="必须填写"/>
        <br />
        1－100的整数,越大透明度越低</td>
    </tr>
    <tr class="submit">
      <td ><input type="submit" name="editsubmit" value="提交" class="button" tabindex="3" /></td>
    </tr>
  </table>
</form>

<script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script> 
<?php echo $this->renderPartial('/_include/footer')?>