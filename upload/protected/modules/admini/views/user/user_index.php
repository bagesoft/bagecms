<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>会员管理</h3>
  <div class="searchArea">
    <ul class="action left" >
      <li><a href="<?php echo $this->createUrl('create')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
    <div class="search right">
      <?php $form = $this->beginWidget('CActiveForm',array('id'=>'searchForm','method'=>'get','htmlOptions'=>array('name'=>'xform'))); ?>
      <select name="groupId" id="groupId">
        <option value="">=组=</option>
        <?php foreach((array)$this->group_list as $group):?>
        <option value="<?php echo $group['id']?>" <?php XUtils::selected($group['id'], $model->group_id);?>><?php echo $group['group_name']?></option>
        <?php endforeach;?>
      </select>
      <select name="sex" id="sex">
        <option value="">性别</option>
        <option value="男">男</option>
        <option value="女">女</option>
      </select>
      用户名
      <input id="username" type="text" name="username" value="" class="txt" size="15"/>
      姓名
      <input id="realname" type="text" name="realname" value="" class="txt" size="15"/>
      <input name="searchsubmit" type="submit" class="button" value="搜索"/>
      <script type="text/javascript">
$(function(){
	$("#xform").validationEngine();	
});
</script>
      <?php $form=$this->endWidget(); ?>
      <script type="text/javascript">
$(document).ready(function(){
	$("#groupId").val('<?php echo $this->_gets->getParam('groupId')?>');
	$("#sex").val('<?php echo $this->_gets->getParam('sex')?>');
	$("#username").val('<?php echo $this->_gets->getParam('username')?>');
	$("#realname").val('<?php echo $this->_gets->getParam('realname')?>');
});
</script> </div>
  </div>
</div>
<table class="content_list">
  <form method="post" action="<?php echo $this->createUrl('batch')?>" name="cpform" >
    <tr class="tb_header">
      <th width="5%">ID</th>
      <th width="20%">用户 </th>
      <th width="12%">姓名</th>
      <th width="15%">组</th>
      <th width="8%">状态</th>
      <th width="13%">注册时间</th>
      <th>操作</th>
    </tr>
    <?php foreach ($datalist as $row):?>
    <tr class="tb_list">
      <td ><?php echo $row->id?></td>
      <td ><?php echo $row->username?><br />
      <?php echo $row->email?></td>
      <td ><?php echo $row->realname?></td>
      <td ><?php echo $row->userGroup->group_name?></td>
      <td ><?php if($row->status_is == 'locker'):?>
        <span class="red"><img src="<?php echo $this->_baseUrl?>/static/admin/images/error.png" align="absmiddle" />锁定</span>
        <?php endif;?></td>
      <td ><?php echo date('Y-m-d H:i',$row->create_time)?></td>
      <td ><a href="<?php echo  $this->createUrl('update',array('id'=>$row->id))?>"><img src="<?php echo $this->_baseUrl?>/static/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo  $this->createUrl('batch',array('command'=>'delete', 'id'=>$row->id))?>" class="confirmSubmit"><img src="<?php echo $this->_baseUrl?>/static/admin/images/delete.png" align="absmiddle" /></a></td>
    </tr>
    <?php endforeach;?>
    <tr>
      <td colspan="7"><div class="cuspages right">
          <?php $this->widget('CLinkPager',array('pages'=>$pagebar));?>
        </div>
        <div class="fixsel" style="display:none">
          <input type="checkbox" name="chkall" id="chkall" onclick="checkAll(this.form, 'id')" />
          <label for="chkall">全选</label>
          <select name="command">
            <option>选择操作</option>
            <option value="userLock">锁定</option>
          </select>
          <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
        </div></td>
    </tr>
  </form>
</table>
<?php $this->renderPartial('/_include/footer');?>
