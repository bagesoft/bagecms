<?php $this->renderPartial('/_include/header')?>

<div class="mainWrap">
<div class="topDesc">
  <div class="desc">
    <p style=" margin-top:40px;">致力于提升客户品牌形象、实现客户商业目标!</p>
    <p>Commitment to enhance customer brand image,customer business goals!</p>
  </div>
</div>
<div class="global clear">
  <?php $this->renderPartial('/_include/sidebar_left')?>
  <div class="mainBox">
    <div class="loc clear">
      <div class="position"> <span>您的位置：</span> <a href="<?php echo Yii::app()->homeUrl?>">首页</a> <em></em> <a href="<?php echo $this->createUrl('/special')?>">专题</a> </div>
    </div>
    <div class="listBox clear">
      <ul>
        <?php foreach((array)$bagecmsDataList as $bagecmsKey=>$bagecmsRow):?>
        <li class="cl">
          <div class="bimg"><a href="<?php echo $this->createUrl('show',array('name'=>$bagecmsRow->title_alias))?>" target="_blank"><img src="<?php echo $this->_baseUrl?>/<?php echo $bagecmsRow->attach_thumb?>" class="tn"></a></div>
          <h2><a href="<?php echo $this->createUrl('show',array('name'=>$bagecmsRow->title_alias))?>" target="_blank" class="title" style=""><?php echo $bagecmsRow->title?></a> </h2>
          <p class="bdesc"><?php echo XUtils::clearCutstr($bagecmsRow->content, 200)?></p>
          <p class="binfo"> <span class="date">时间&nbsp;: <?php echo date('Y-m-d',$bagecmsRow->create_time) ?></span> </p>
        </li>
        <?php endforeach?>
      </ul>
    </div>
    <div class="pagebar clear">
      <?php $this->widget('CLinkPager',array('pages'=>$bagecmsPagebar));?>
    </div>
  </div>
</div>
<?php $this->renderPartial('/_include/footer')?>
