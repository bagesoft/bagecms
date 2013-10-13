<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>属性</h3>
  <div class="searchArea">
    <ul class="action left" >
      <li class="current"><a href="<?php echo $this->createUrl('create')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
    <div class="search right"> </div>
  </div>
</div>
<table class="content_list">
  <form method="post" action="<?php echo $this->createUrl('batch',array('command'=>'delete'))?>" name="cpform" >
    <tr class="tb_header">
      <th width="8%"> ID</th>
      <th width="8%"> 排序</th>
      <th width="20%">名称</th>
      <th width="15%">录入时间</th>
      <th>操作</th>
    </tr>
    <?php foreach ((array)$datalist as $row):?>
    <tr class="tb_list">
      <td ><input type="checkbox" name="id[]" value="<?php echo $row['id']?>">
        <?php echo $row['id']?></td>
      <td ><input name="sortOrder[<?php echo $row['id']?>]" type="text" id="sortOrder[]" value="<?php echo $row['sort_order']?>" size="5" /></td>
      <td >[
        <?php if($row->scope =='config'):?>
        配置项
        <?php else:?>
        内容项
        <?php endif?>
        ] <?php echo $row['attr_name'] ?></td>
      <td ><?php echo date('Y-m-d H:i',$row['create_time'])?></td>
      <td ><a href="<?php echo  $this->createUrl('update',array('id'=>$row['id']))?>"><img src="<?php echo $this->_baseUrl?>/static/admin/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;<a href="<?php echo  $this->createUrl('batch',array('command'=>'delete', 'id'=>$row['id']))?>" class="confirmSubmit"><img src="<?php echo $this->_baseUrl?>/static/admin/images/delete.png" align="absmiddle" /></a></td>
    </tr>
    <?php endforeach;?>
    <tr class="operate">
      <td colspan="9"><div class="cuspages right">
          <?php $this->widget('CLinkPager',array('pages'=>$pagebar));?>
        </div>
        <div class="fixsel">
          <input type="checkbox" name="chkall" id="chkall" onclick="checkAll( this.form, 'id')" />
          <label for="chkall">全选</label>
          <select name="command">
            <option>选择操作</option>
            <option value="sortOrder">排序</option>
            <option value="delete">删除</option>
            <option value="verify">显示</option>
            <option value="unVerify">隐藏</option>
          </select>
          <input id="submit_maskall" class="button confirmSubmit" type="submit" value="提交" name="maskall" />
        </div></td>
    </tr>
  </form>
</table>
<?php $this->renderPartial('/_include/footer');?>
