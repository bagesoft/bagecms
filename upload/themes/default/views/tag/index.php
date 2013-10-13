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
          <div class="position"> <span>您的位置：</span> <a href="<?php echo Yii::app()->homeUrl?>">首页</a> <em></em> <span>标签</span> </div>
        </div>
        <div class="clear">
           <ul class="tagList">
			<?php foreach($bagecmsDataList as $row):?>
            <li><a href="<?php echo $this->createUrl('post',array('name'=>urlencode($row->tag_name)))?>" target="_blank" title="<?php echo $row->tag_name?>共有<?php echo $row->data_count?>条内容"><?php echo $row->tag_name?></a></li>
            <?php endforeach?>
          </ul>
        </div>
        <div class="pagebar clear">
          <?php $this->widget('CLinkPager',array('pages'=>$bagecmsPagebar));?>
        </div>
      </div>
    </div>
<?php $this->renderPartial('/_include/footer')?>