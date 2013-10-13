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
      <div class="position"> <span>您的位置：</span> <a href="<?php echo Yii::app()->homeUrl?>">首页</a> <em></em> <span>专题</span> </div>
    </div>
    <div class="postWrap">
      <div class="h head">
        <h1 class="title"><?php echo $specialShow->title?></h1>
        <p class="info"> <?php echo date('Y-m-d H:i:s',$specialShow->create_time)?><span class="split">|</span> 发布者: admin<span class="split">|</span> 查看: <em id="_viewnum"><?php echo $specialShow->view_count?></em></p>
      </div>
      <?php if($specialShow->intro):?>
      <div class="intro"><?php echo $specialShow->intro?></div>
      <?php endif?>
      <div class="cdata">
        <table cellpadding="0" cellspacing="0" class="showTb">
          <tbody>
            <tr>
              <td id="postContent"><?php echo $specialShow->content?></td>
            </tr>
          </tbody>
        </table>
        <dl class="specialPost">
        <dt>专题资讯</dt>
          <?php foreach((array)$specialPostList as $key=>$row):?>
          <dd><a href="<?php echo $this->createUrl('post/show',array('id'=>$row->id))?>" target="_blank"><?php echo $row->title?></a></dd>
          <?php endforeach?>
        </dl>
        <div class="pagebar clear">
          <?php $this->widget('CLinkPager',array('pages'=>$bagecmsPagebar));?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $this->renderPartial('/_include/footer')?>
