<?php $this->renderPartial('/_include/header');?>

<div id="contentHeader">
  <h3>邮件/短信模板</h3>
  <div class="searchArea">
    <ul class="action left" >
      <li ><a href="<?php echo $this->createUrl('sendTpl')?>" class="actionBtn"><span>返回</span></a></li>
      <li class="current"><a href="<?php echo $this->createUrl('sendTplCreate')?>" class="actionBtn"><span>录入</span></a></li>
    </ul>
    <div class="search right"> </div>
  </div>
</div>
<?php $this->renderPartial('_send_tpl_form',array('model'=>$model))?>
<?php $this->renderPartial('/_include/footer');?>
