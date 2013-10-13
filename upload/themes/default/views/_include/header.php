<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title><?php echo $this->_seoTitle?> - Powered By BageCMS</title>
<meta name="generator" content="BageCMS CMS" />
<meta name="author" content="shuguang" />
<meta name="keywords" content="<?php echo $this->_seoKeywords?>">
<meta name="description" content="<?php echo $this->_seoDescription?>">
<link rel="stylesheet" href="<?php echo $this->_theme->baseUrl?>/css/style.css">
<?php Yii::app()->clientScript->registerCoreScript('jquery',CClientScript::POS_END); ?>
<script type="text/javascript" src="<?php echo $this->_baseUrl?>/static/js/jquery.SuperSlide.2.1.js"></script>
</head>
<body>
<div class="container">
<!--头-->
<div id="header" class="header">
  <div class="wrap">
    <div class="logo floatL">
      <h1>八哥CMS</h1>
    </div>
    <div class="nav floatL">
      <div class="clear">
        <dl class="tnLeft">
          <dd>
            <h3><a href="<?php echo Yii::app()->homeUrl?>">首页</a></h3>
          </dd>
          <?php foreach((array)$this->_catalog as $key=>$row):?>
          <?php if($row['parent_id'] == 0):?>
          <dd>
            <h3><a href="<?php echo $this->createUrl('post/index',array('catalog'=>$row['catalog_name_alias'])) ?>"><?php echo $row['catalog_name']?><i></i></a></h3>
            <ul>
              <?php foreach((array)Catalog::lite($row['id']) as $key=>$val):?>
              <li><a href="<?php echo $this->_navLink($val)?>"><?php echo $val['catalog_name']?></a></li>
              <?php endforeach?>
            </ul>
          </dd>
          <?php endif?>
          <?php endforeach?>
          <dd>
            <h3><a href="<?php echo $this->createUrl('/special')?>">专题</a></h3>
          </dd>
          <dd>
            <h3><a href="<?php echo $this->createUrl('/tag')?>">标签</a></h3>
          </dd>
          <dd>
            <h3><a href="<?php echo $this->createUrl('/question')?>">留言咨询</a></h3>
          </dd>
        </dl>
      </div>
    </div>
    <script type="text/javascript">jQuery(".nav").slide({ type:"menu",  titCell:"dd", targetCell:"ul", delayTime:0,defaultPlay:false,returnDefault:true  });	</script> 
    
    <!--<div class="nav floatL">
      <ul>
        <li><a href="<?php echo Yii::app()->homeUrl?>">首页</a></li>
       <?php foreach((array)$this->_catalog as $key=>$row):?>
       <?php if($row['parent_id'] == 0):?>
        <li class="mainlevel"><a href="<?php echo $this->createUrl('post/index',array('catalog'=>$row['catalog_name_alias'])) ?>"><?php echo $row['catalog_name']?></a>
		   <ul class="navSub">
          <?php foreach((array)Catalog::lite($row['id']) as $key=>$val):?>
          <li><a href="<?php echo $this->_navLink($val)?>"><?php echo $val['catalog_name']?></a></li>
          <?php endforeach?>
          </ul>
        </li>
        <?php endif?>
         <?php endforeach?>
         <li><a href="<?php echo $this->createUrl('/special')?>">专题</a></li>
      <li><a href="<?php echo $this->createUrl('/tag')?>">标签</a></li>
        <li><a href="<?php echo $this->createUrl('/question')?>">留言咨询</a></li>
      </ul>
    </div>-->
    <div class="subnav"> <i class="z"></i> <span> <a href="http://www.bagesoft.cn" >八哥软件</a> &nbsp;&nbsp;&nbsp; 咨询QQ：5565907 </span> <i class="y"></i> </div>
  </div>
</div>
<!--/头--> 
