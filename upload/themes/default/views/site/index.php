<?php $this->renderPartial('/_include/header')?>

<!--广告-->
<?php $indexAd = Bagecms::getList('ad','index_ad',array('where'=>"status_is='Y' AND title_alias='index_banner'", 'order'=>'sort_order DESC'))?>
<div class="banner">
  <div class="bd">
    <ul>
	<?php foreach((array)$indexAd as $ad):?>
	<?php if($ad['link_url']):?>
     <li _src="url(<?php if($ad['image_url']):?><?php echo $ad['image_url']?><?php else:?><?php echo $this->_baseUrl?>/<?php echo $ad['attach_file']?><?php endif?>)" style="background:#DED5A1 center 0 no-repeat;"><a target="_blank" href="<?php echo $ad['link_url']?>"></a></li>
	 <?php else:?>
	 <li _src="url(<?php if($ad['image_url']):?><?php echo $ad['image_url']?><?php else:?><?php echo $this->_baseUrl?>/<?php echo $ad['attach_file']?><?php endif?>)" style="background:#DED5A1 center 0 no-repeat;"></li>
	<?php endif?>
	<?php endforeach?>
    </ul>
  </div>
  <div class="hd">
    <ul>
    </ul>
  </div>
  <span class="prev"></span><span class="next"></span></div>
<script type="text/javascript">
jQuery(".banner").hover(function(){jQuery(this).find(".prev,.next").stop(true,true).fadeTo(4000,0.5)},function(){jQuery(this).find(".prev,.next").fadeOut()});jQuery(".banner").slide({titCell:".hd ul",mainCell:".bd ul",effect:"fold",autoPlay:true,autoPage:true,trigger:"click",startFun:function(i){var curLi=jQuery(".banner .bd li").eq(i);if(!!curLi.attr("_src")){curLi.css("background-image",curLi.attr("_src")).removeAttr("_src")}}});
</script>
<!--/广告-->

<div class="index">
<?php $bagecmsAbout = Bagecms::getItem('page','index_about', array('where'=>"title_alias='about'"));?>
<!--首页模块-->
<div class="module clear">
  <div class="wrap">
    <div class="moduleBox about">
      <div class="col">
        <div>
          <h2>公司简介<em>ABOUT</em></h2>
          <a href="<?php echo $this->createUrl('page/show',array('name'=>'about'))?>" class="move" target="_blank">更多</a></div>
      </div>
      <div class="con">
        <?php if($bagecmsAbout['attach_file']):?>
        <img src="<?php echo $this->_baseUrl?>/<?php echo $bagecmsAbout['attach_file']?>"  />
        <?php endif?>
        <p><?php echo $bagecmsAbout['intro']?></p>
        <p><a href="<?php echo $this->createUrl('page/show',array('name'=>'about'))?>" class="link floatR" target="_blank">了解更多</a></p>
      </div>
    </div>
    <div class="moduleBox cultural">
      <div class="col">
        <h2>企业文化<em>CULTURAL</em></h2>
        <a href="<?php echo $this->createUrl('page/show',array('name'=>'cultural'))?>" class="move" target="_blank">更多</a> </div>
      <div class="con">
        <h3>愿景:</h3>
        <p>最受尊敬的互联网企业</p>
        <h3>使命:</h3>
        <p>通过互联网服务提升人类生活品质。</p>
        <h3>价值观:</h3>
        <p>正直，进取，合作，创新</p>
        <h3>经营理念:</h3>
        <p>一切以用户价值为依归</p>
      </div>
    </div>
    <div class="moduleBox post">
      <div class="col">
        <h2>公司动态<em>NEWS</em></h2>
        <a href="<?php echo $this->createUrl('post/index',array('catalog'=>'company-news'))?>" class="move" target="_blank">更多</a> </div>
      <div class="con">
        <ul>
          <?php foreach((array)Bagecms::getList('post','index_news',array('where'=>"status_is='Y' AND catalog_id=2",'order'=>'id DESC', 'limit'=>10)) as $newsKey=>$newsRow):?>
          <li><em class="date"><?php echo date('m-d',$newsRow['create_time'])?></em><a href="<?php echo $this->createUrl('post/show',array('id'=>$newsRow['id']))?>" target="_blank"><?php echo $newsRow['title']?></a></li>
          <?php endforeach?>
        </ul>
      </div>
    </div>
  </div>
</div>
<!--/首页模块--> 
<!--商品-->

<div class="wrap clear ">
  <div class="indexGoods">
    <div class="col">
      <h2>产品展示<em>PRODUCT</em></h2>
      <a href="<?php echo $this->createUrl('post/index',array('catalog'=>'new-arrival'))?>" class="move" target="_blank">更多</a> </div>
    <div class="scrollBox">
      <div class="goodsImage">
        <ul class="list" >
          <?php foreach((array)Bagecms::getList('post','index_goods',array('where'=>"status_is='Y' AND catalog_id=5",'order'=>'id DESC', 'limit'=>8)) as $goodsKey=>$goodsRow):?>
          <li style="float: left; width: 162px; "><a href="<?php echo $this->createUrl('post/show',array('id'=>$goodsRow['id']))?>" target="_blank" title="<?php echo $goodsRow['title']?>"><img src="<?php echo $this->_baseUrl ?>/<?php echo $goodsRow['attach_file']?>" width="162" height="120" alt="<?php echo $goodsRow['title']?>"><span><?php echo $goodsRow['title']?></span></a></li>
          <?php endforeach?>
        </ul>
         </div>
    </div>
  </div>
</div>
<script type="text/javascript">
jQuery(".indexGoods").slide({ mainCell:"ul", effect:"leftMarquee", vis:5, autoPlay:true, interTime:50, switchLoad:"_src" });	</script> 
<?php $this->renderPartial('/_include/footer')?>


