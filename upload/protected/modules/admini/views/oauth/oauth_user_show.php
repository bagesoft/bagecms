<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>第三方登录</h3>
  <div class="searchArea">
    <ul class="action left" >
      <li ><a href="<?php echo $this->createUrl('oauth')?>" class="actionBtn"><span>管理</span></a></li>
    </ul>
    <div class="search right"> </div>
  </div>
</div>
<?php $this->renderPartial('_oauth_user_form',array('model'=>$model))?>
<?php $this->renderPartial('/_include/footer');?>
