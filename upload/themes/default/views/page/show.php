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
      <div class="position"> <span>您的位置：</span> <a href="<?php echo Yii::app()->homeUrl?>">首页</a> <em></em> <span>关于</span><em></em><a href="<?php echo $this->createUrl('page/show',array('name'=>$bagecmsPage['title_alias']))?>"><?php echo $bagecmsPage['title']?></a> </div>
    </div>
	<div class="postWrap">
	<div class="h head">
        <h1 class="title"><?php echo $bagecmsPage->title?></h1>
      </div>
    <div class="clear cdata">
     <?php echo $bagecmsPage['content']?> 
    </div>
	</div>
  </div>
</div>
<?php $this->renderPartial('/_include/footer')?>
