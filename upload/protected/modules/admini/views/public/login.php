<!DOCTYPE html>

<head>
<meta charset="utf-8">
<title>管理登录 - BageCMS</title>
<meta name="keywords" content="bagecms,bageSOFT" />
<meta name="description" content="bagecms(八哥CMS),专业的建站工具" />
<meta name="generator" content="BageCMS3.1" />
<meta name="author" content="bagecms.com" />
<meta name="copyright" content="2013-2014 bagecms.com" />
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl?>/static/admin/css/login-style.css" />
<script type="text/javascript" language="javascript">
    //<![CDATA[
    // show login form in top frame
    if (top != self) {
        window.top.location.href = location;
    }
    //]]>
</script>
</head>
<body>
<div id="login">
  <div class="wrapper">
    <div class="alert error" >&nbsp;</div>
    <div class="logo"></div>
    <div class="form">
      <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-wrap',
	'enableAjaxValidation'=>true,
)); ?>
      <dl>
        <dt>用户名</dt>
        <dd> <?php echo $form->textField($model,'username', array('class'=>'input-password')); ?> <?php echo $form->error($model,'username'); ?> </dd>
        <dt>密&nbsp;&nbsp;&nbsp;&nbsp;码</dt>
        <dd> <?php echo $form->passwordField($model,'password', array('class'=>'input-password')); ?> <?php echo $form->error($model,'password'); ?> </dd>
        <dt>验证码</dt>
        <dd> <?php echo $form->textField($model,'captcha', array('class'=>'input-password verify-code')); ?>
          <?php $this->widget ( 'CCaptcha', array ('showRefreshButton' => true, 'clickableImage' => true, 'buttonType' => 'link', 'buttonLabel' => '换一张', 'imageOptions' => array ('alt' => '点击换图', 'align'=>'absmiddle'  ) ) );?>
          <?php echo $form->error($model,'captcha'); ?> </dd>
        <dd>
          <input type="submit" name="login" class="input-login" value=""/>
          <input type="reset" name="login" class="input-reset" value=""/>
        </dd>
      </dl>
      <?php $this->endWidget(); ?>
    </div>
    <br class="clear-fix"/>
    <div class="copyright">Copyright&copy; <a title="bagecms" target="_blank" href="http://www.bagecms.com">bagecms.com</a>. All Thrusts Reserved.</div>
  </div>
</div>
</body>
</html>