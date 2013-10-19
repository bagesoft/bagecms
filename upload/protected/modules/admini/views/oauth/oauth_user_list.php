<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>第三方登录</h3>
  
</div>
<table class="content_list">
  <form method="post" action="" name="cpform" >
    <tr class="tb_header">
      <th width="5%">ID</th>
      <th width="12%">登录接口 </th>
      <th width="12%">接口返回ID</th>
      <th width="18%">平台用户</th>
      <th width="10%">真实姓名</th>
      <th width="12%">绑定时间</th>
      <th >操作</th>
    </tr>
    <?php foreach ($datalist as $row):?>
    <tr class="tb_list">
      <td ><?php echo $row->id?></td>
      <td ><?php echo $row->api?></td>
      <td ><?php echo $row->api_uid?></td>
      <td><?php echo $row->user->username?></td>
      <td ><?php echo $row->user->realname?></td>
      <td ><?php echo date('Y-m-d H:i',$row->create_time)?></td>
      <td ><a href="<?php echo  $this->createUrl('oauthShow',array('id'=>$row->id))?>"><img src="<?php echo $this->_baseUrl?>/static/admin/images/update.png" align="absmiddle" /></a><!-- <a href="<?php echo  $this->createUrl('batch',array('command'=>'adminDelete', 'id'=>$row->id))?>" class="confirmSubmit"><img src="<?php echo $this->_baseUrl?>/static/admin/images/delete.png" align="absmiddle" /></a>--></td>
    </tr>
    <?php endforeach;?>
    <tr>
      <td colspan="7"><div class="cuspages right">
          <?php $this->widget('CLinkPager',array('pages'=>$pagebar));?>
        </div>
        
        <!--<div class="fixsel">
                    <input type="checkbox" name="chkall" id="chkall" onclick="checkAll('prefix', this.form, 'opentid')" />
                    <label for="chkall">全选</label>
                    <input id="submit_maskall" class="btn" type="submit" value="屏蔽" name="maskall" />
                    <input id="submit_unmaskall" class="btn" type="submit" value="取消屏蔽" name="unmaskall" />
                </div>--></td>
    </tr>
  </form>
</table>
<?php $this->renderPartial('/_include/footer');?>
