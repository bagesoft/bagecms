<script type="text/javascript">
$(function(){ 
    $(".confirmSubmit").click(function() {
        return confirm('本操作不可恢复，确定继续？');
    });
}); 
/*
关键词整获取
*/
function keywordGet(keywordId,keywordIdSet){
	var keyword = $("#"+keywordId).val();
	$.post('<?php echo $this->createUrl('keyword')?>',{string:keyword},function(res){
		if(res.state =='error'){
			alert('获取失败，请手动填写');
		}else{
			$("#"+keywordIdSet).val(res.datas);
		}
	},'json')
}

function uploadifyAction(fileField,frameId) {
    $.Zebra_Dialog('', {
        source: {
            'iframe': {
                'src': '<?php echo $this->createUrl('uploadify/basic')?>',
                'height': 300,
                'name': 'bagecms_com',
                'id': 'bagecms_com'
            }
        },
        width: 600,
        'buttons': [
			{
				caption: '确认',
				callback: function() {
					var htmls = $(window.frames['bagecms_com'].document).find("#fileListWarp").html();
					if(htmls){
						$("#" + fileField).append(htmls);
					}else{
						 alert('没有文件被选择');
					}
				}
			},
			{
				caption: '取消',
				callback: function() {
					return;
				}
			}
		],
        'type': false,
        'title': '附件上传',
        'modal': false
    });
}


function uploadifyRemove(fileId,attrName){
	if(confirm('本操作不可恢复，确定继续？')){
		$.post("<?php echo $this->createUrl('uploadify/remove')?>",{imageId:fileId},function(res){
			$("#"+attrName+fileId).remove();
		},'json');
	}
}
</script>
</div>
</body>
</html>