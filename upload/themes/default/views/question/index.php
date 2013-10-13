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
  <div class="mainBox question">
    <div class="loc clear">
      <div class="position"> <span>您的位置：</span> <a href="<?php echo Yii::app()->homeUrl?>">首页</a> <em></em> <span>留言咨询</span> </div>
    </div>
    <div class=" clear">
      <form name="questionForm" id="questionForm" method="post" >
      <dl>
      <dt>姓名：</dt>
      <dd> <input name="Question[realname]" type="text" id="Question[realname]" size="50"/></dd>
      <dt>邮箱：</dt>
      <dd> <input name="Question[email]" type="text" id="Question[email]" size="50"/></dd>
      <dt>电话：</dt>
      <dd> <input name="Question[telephone]" type="text" id="Question[telephone]" size="50"/></dd>
      <dt>其它联系方式：</dt>
      <dd><input name="Question[contact_other]" type="text" id="Question[contact_other]"  size="50"/></dd>
      <dt>内　　容：</dt>
      <dd>  <textarea name="Question[question]" class="msg_input" style="width:650px;height:180px;overflow:auto;" id="Question[content]" ></textarea></dd>
      <dd>  <input name="submit" type="button" id="questionPost" value="提交" class="button"/><div id="errorMessage"></div></dd>
      </dl>
      </form>
      <?php foreach((array)$bagecmsQuestionList as $key=>$row):?>
      <dl class="qlist">
        <dt><?php echo date('Y-m-d H:i:s',$row->create_time) ?> 收到来自：<span><?php echo $row->realname?></span>留言</dt>
        <dd><?php echo CHtml::encode($row->question)?></dd>
       <?php if($row->answer_content):?>
        <dd class="reply">管理回复</dd>
        <dd><?php echo nl2br(CHtml::encode($row->answer_content))?></dd>
        <?php endif?>
      </dl>
      <?php endforeach?>
    </div>
    <div class="pagebar ">
      <?php $this->widget('CLinkPager',array('pages'=>$pages));?>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function(){
	$("#questionPost").click(function(){
		$.post("<?php echo $this->createUrl('question/post')?>",$("#questionForm").serializeArray(),function(res){
			if(res.state == 'success'){
				alert(res.message);
				window.location.reload();
			}else{
				$("#errorMessage").html(res.message);
			}
		},'json');	
	});	
})
</script>
<style>
/* 错误提示*/
.errorSummary { padding: 5px; background: #FFFF80; border: 1px solid #C4C43C; }
.errorSummary p { font-size: 14px; font-weight: bold; }
.errorSummary li { padding: 5px 0 }
</style>
<?php $this->renderPartial('/_include/footer')?>
