<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>BageCMS管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="bagecms.com." name="Copyright">
<script>
	var webUrl = '<?php echo Yii::app()->request->getHostInfo()?>';
	var staticPath = '<?php echo $this->_baseUrl?>/static/';
	var currentScript = '<?php echo Yii::app()->request->getScriptUrl()?>';
</script>
<link rel="stylesheet" type="text/css" href='<?php echo $this->_baseUrl?>/static/admin/css/common.css'>
<script src="<?php echo $this->_baseUrl?>/static/js/jquery/jquery-1.7.1.min.js" ></script>
<script src="<?php echo $this->_baseUrl?>/static/js/jquery/jquery.form.js" ></script>
<script src="<?php echo $this->_baseUrl?>/static/js/jquery/jquery.tools.min.js" ></script>
<script src="<?php echo $this->_baseUrl?>/static/admin/js/base.js" ></script>
<script type="text/javascript" src="<?php echo $this->_baseUrl?>/static/js/My97DatePicker/WdatePicker.js"></script>
<script src="<?php echo $this->_baseUrl?>/static/js/validationEngine/jquery.validationEngine.min.js" ></script>
<link rel="stylesheet" type="text/css" href="<?php echo $this->_baseUrl?>/static/js/zebra_dialog/css/zebra_dialog.css">
<script src="<?php echo $this->_baseUrl?>/static/js/zebra_dialog/zebra_dialog.js"></script>
</head>
<body>
<div id="append_parent"></div>
<div class="container" id="cpcontainer">
