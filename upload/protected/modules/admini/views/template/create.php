<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>模板</h3>
  <div class="searchArea">
    <ul class="action left" >
      <li ><a href="<?php echo $this->createUrl('index')?>" class="actionBtn"><span>返回</span></a></li>
    </ul>
    <div class="search right"> </div>
  </div>
</div>
<?php $this->renderPartial('_form',array('model'=>$model, 'folderName'=>$folderName))?>
<?php $this->renderPartial('/_include/footer');?>
