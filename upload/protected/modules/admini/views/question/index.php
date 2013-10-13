<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>留言反馈</h3>
  <div class="searchArea">
    <ul class="action left" >
    </ul>
    <div class="search right">
      <?php $form = $this->beginWidget('CActiveForm',array('id'=>'searchForm','method'=>'get','htmlOptions'=>array('name'=>'xform'))); ?>
      <!-- <select name="catalog" id="catalog">
        <option value="">==操作类型==</option>
        <option value="login">登录</option>
        <option value="create">录入</option>
        <option value="delete">删除</option>
        <option value="update">编辑</option>
      </select>--> 
      姓名:
      <input id="realname" type="text" name="realname" value="" class="txt" size="15"/>
      内容:
      <input id="question" type="text" name="question" value="" class="txt" size="15"/>
      <input name="searchsubmit" type="submit" class="button" value="搜索"/>
      <?php $form=$this->endWidget(); ?>
      <script type="text/javascript">
$(document).ready(function(){
	$("#question").val('<?php echo $this->_gets->getParam('question')?>');
	$("#realname").val('<?php echo $this->_gets->getParam('realname')?>');
});
</script> </div>
  </div>
</div>
<table class="content_list">
  <form method="post" action="<?php echo $this->createUrl('batch')?>" name="cpform" >
    <tr class="tb_header">
      <th width="8%">ID</th>
      <th>内容</th>
      <th width="15%">操作时间</th>
      <th width="8%">操作</th>
    </tr>
    <?php foreach ($datalist as $row):?>
    <tr class="tb_list">
      <td ><input type="checkbox" name="id[]" value="<?php echo $row->id?>">
        <?php echo $row->id?></td>
      <td ><?php echo nl2br(htmlspecialchars($row->question))?>
        <?php if($row->answer_content):?>
        <div class="answer_content"><?php echo htmlspecialchars($row->answer_content)?></div>
        <?php endif?></td>
      <td ><?php echo date('Y-m-d H:i',$row->create_time)?></td>
      <td ><a href="<?php echo  $this->createUrl('update',array('id'=>$row->id))?>"><img src="<?php echo $this->_baseUrl?>/static/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo  $this->createUrl('batch',array('command'=>'delete', 'id'=>$row->id))?>" class="confirmSubmit"><img src="<?php echo $this->_baseUrl?>/static/admin/images/delete.png" align="absmiddle" /></a></td>
    </tr>
    <?php endforeach;?>
    <tr class="submit">
      <td colspan="5"><div class="cuspages right">
          <?php $this->widget('CLinkPager',array('pages'=>$pagebar));?>
        </div>
        <div class="fixsel" >
          <input type="checkbox" name="chkall" id="chkall" onclick="checkAll(this.form, 'id')" />
          <label for="chkall">全选</label>
          <select name="command">
            <option value="">选择操作</option>
            <option value="adminLoggerDelete">删除</option>
          </select>
          <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
        </div></td>
    </tr>
  </form>
</table>
<?php $this->renderPartial('/_include/footer');?>
