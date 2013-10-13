<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>管理员组</h3>
  <div class="searchArea">
    <ul class="action left" >
      <li ><a href="<?php echo $this->createUrl('group')?>" class="actionBtn"><span>管理</span></a></li>
      <li class="current"><a href="<?php echo $this->createUrl('groupCreate')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
    <div class="search right"> </div>
  </div>
</div>
<?php $this->renderPartial('_group_form',array('model'=>$model))?>
<?php $this->renderPartial('/_include/footer');?>
