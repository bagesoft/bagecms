<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>邮件/短信模板</h3>
  <div class="searchArea">
    <ul class="action left" >
      <li ><a href="<?php echo $this->createUrl('sendTplCreate')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
    <div class="search right"> </div>
  </div>
</div>
<table class="content_list">
  <form method="post" name="cpform" >
    <tr class="tb_header">
      <th width="5%">ID</th>
      <th width="15%">模板标识</th>
      <th  width="25%">模板名称</th>
      <th >发送标题</th>
      <th width="12%">录入时间</th>
      <th>操作</th>
    </tr>
    <?php foreach ($datalist as $row):?>
    <tr class="tb_list">
      <td ><?php echo $row->id?></td>
      <td ><?php echo $row->link_label?></td>
      <td ><a href="<?php echo  $this->createUrl('sendTplUpdate',array('id'=>$row->id))?>"  title="<?php echo $row->title?>"><?php echo $row->title?></a></td>
      <td ><?php echo $row->send_title?></td>
      <td ><?php echo date('Y-m-d H:i',$row->create_time)?></td>
      <td ><a href="<?php echo  $this->createUrl('sendTplUpdate',array('id'=>$row->id))?>"><img src="<?php echo $this->_baseUrl?>/static/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo  $this->createUrl('batch',array('command'=>'sendTplDelete','id'=>$row->id))?>" class="confirmSubmit"><img src="<?php echo $this->_baseUrl?>/static/admin/images/delete.png" align="absmiddle" /></a></td>
    </tr>
    <?php endforeach;?>
    <tr class="operate">
      <td colspan="6"><div class="cuspages right">
          <?php $this->widget('CLinkPager',array('pages'=>$pagebar));?>
        </div>
        <div class="fixsel" style="display:none">
          <input type="checkbox" name="chkall" id="chkall" onclick="checkAll('prefix', this.form, 'opentid')" />
          <label for="chkall">全选</label>
          <input id="submit_maskall" class="btn" type="submit" value="屏蔽" name="maskall" />
          <input id="submit_unmaskall" class="btn" type="submit" value="取消屏蔽" name="unmaskall" />
        </div></td>
    </tr>
  </form>
</table>
<?php $this->renderPartial('/_include/footer');?>
