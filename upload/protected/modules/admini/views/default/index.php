<!doctype html>
<html>
<head>
<title>BageCMS管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl?>/static/admin/css/manage.css">
<script type="text/javascript" src="<?php echo $this->_baseUrl?>/static/js/jquery/jquery-1.7.1.min.js"></script>
</head>

<body scroll="no">
<div class="header">
  <div class="logo">bagecms.com</div>
  <div class="nav">
    <ul>
      <?php $i = 0; foreach(XAdminiAcl::filterMenu() as $key=>$row):?>
      <li index="<?php echo $i ?>">
        <div><a href="<?php echo $this->createUrl($row['url']) ?>" target="win" hidefocus><?php echo $key ?></a></div>
      </li>
      <?php $i++;endforeach;?>
    </ul>
  </div>
  <div class="logininfo"><span class="welcome"><img src="<?php echo $this->_baseUrl?>/static/admin/images/user_edit.png" align="absmiddle"> 欢迎, <em><?php echo $this->_xsession['_adminiUserName']?></em> </span> <a href="<?php echo $this->createUrl('admin/ownerUpdate')?>" target="win">修改密码</a> <a href="<?php echo $this->createUrl('public/logout')?>" target="_top">退出登录</a> <a href="<?php echo Yii::app()->homeUrl?>" target="_blank">前台首页</a></div>
</div>
<div class="topline">
  <div class="toplineimg left" id="imgLine"></div>
</div>
<div class="main" id="main">
  <div class="mainA">
    <div id="leftmenu" class="menu">
      <?php $i = 0; foreach(XAdminiAcl::filterMenu() as $key=>$row):?>
      <ul index="<?php echo $i ?>" class="left_menu">
        <?php foreach((array)$row['action'] as $k=>$rc):?>
        <li index="<?php echo $k ?>"><a href="<?php echo $this->createUrl($rc['url'])?>" target="win"><?php echo $rc['name'] ?></a></li>
        <?php endforeach;?>
      </ul>
      <?php $i++; endforeach;?>
    </div>
  </div>
  <div class="mainB" id="mainB">
    <iframe src="<?php echo $this->createUrl('default/home')?>" name="win" id="win" width="100%" height="100%" frameborder="0"></iframe>
  </div>
</div>
<script type="text/javascript">
window.onload =window.onresize= function(){winresize();}
function winresize()
{
function $(s){return document.getElementById(s);}
var D=document.documentElement||document.body,h=D.clientHeight-90,w=D.clientWidth-160;
 $("main").style.height=h+"px";
 $("mainB").style.width=w+"px";
}
$(document).ready(function(){
    var s=document.location.hash;
    if(s==undefined||s==""){s="#0_0";}
    s=s.slice(1);
    var navIndex=s.split("_");
    $(".nav").find("li:eq("+navIndex[0]+")").addClass("active");
    var targetLink=$(".menu").find("ul").hide().end()
                             .find(".left_menu:eq("+navIndex[0]+")").show()
                             .find("li:eq("+navIndex[1]+")").addClass("active")
                             .find("a").attr("href");
    $("#win").attr("src",targetLink);
    $(".nav").find("li").click(function(){
        $(this).parent().find("li").removeClass("active").end().end()
               .addClass("active");
        var index=$(this).attr("index");
        $(".menu").find(".left_menu").hide();
        $(".menu").find(".left_menu:eq("+index+")").show()
                  .find("li").removeClass("active").first().addClass("active");
        document.location.hash=index+"_0";
    });
    $(".left_menu").find("li").click(function(){
            $(this).parent().find("li").removeClass("active").end().end()
                            .addClass("active");
        document.location.hash=$(this).parent().attr("index")+"_"+$(this).attr("index");
    });
});
</script>
</body>
</html>