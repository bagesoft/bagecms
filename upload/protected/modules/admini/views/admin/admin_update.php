<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>管理员</h3>
  <div class="searchArea">
    <ul class="action left" >
      <li ><a href="<?php echo $this->createUrl('index')?>" class="actionBtn"><span>管理</span></a></li>
      <li ><a href="<?php echo $this->createUrl('create')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
    <div class="search right"> </div>
  </div>
</div>
<?php $this->renderPartial('_admin_form',array('model'=>$model))?>
<?php $this->renderPartial('/_include/footer');?>
