<!-- uploadify end -->
<script src="<!--{$assets}-->/uploadify/jquery.uploadify.min.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<!--{$assets}-->/uploadify/uploadify.css">  
<style type="text/css">
    .uploadify-button {
        background-color: transparent;
        border: none;
        padding: 0;
    }
    .uploadify:hover .uploadify-button {
        background-color: transparent;
    }
</style>
<!-- uploadify end -->
<script type="text/javascript">
$(function(){
	var uploadIds = [];
	for (var key in uploadSettings){
		uploadIds.push("#"+key);
	}
	var uploadDefaults = {
		swf : '<!--{$assets}-->/uploadify/uploadify.swf',
		uploader : './uploadify/uploadify.php',
		multi : true,
		width : 42,
		height : 29,
		buttonText :'上传',
		buttonImage : '<!--{$assets}-->/uploadify/button-submit.png',
		fileTypeDesc : '图片格式',
		fileTypeExts : '*.jpg;*.jpeg;*.png;*.gif;*.bmp',
		formData : { '<!--{$sess_name}-->' : '<!--{$sess_id}-->' }, //传输数据
		onUploadSuccess : function(file, data, response) {},  
		onUploadError : function(file, errorCode, errorMsg, errorString){
			alert('文件 ' + file.name + ' 不能被上传: ' + errorString);  
		},
		onUploadProgress : function(file, bytesUploaded, bytesTotal, totalBytesUploaded, totalBytesTotal){
			$('#progress').html(totalBytesUploaded + ' bytes uploaded of ' + totalBytesTotal + ' bytes.');  
		},
		onUploadComplete : function(file){},
	};
    $(uploadIds.join(',')).each(function(i,item){
    	var finalSettings = $.extend(true,{},uploadDefaults, uploadSettings[this.id]);
    	$(item).uploadify(finalSettings);
    });
    
    $('a[href=#imgup]').live('click', function(){
		var imgP = $(this).parent('span').parent('span').parent('p');
		var b = imgP.prev();
		if(b.hasClass('photo_p')){
			b.before(imgP);
			setImageSort(b);
		}
	});
	$('a[href=#imgdown]').live('click', function(){
		var imgP = $(this).parent('span').parent('span').parent('p');
		var n = imgP.next();
		if(n.hasClass('photo_p')){
			n.after(imgP);
			setImageSort(n);
		}
	});
	$('a[href=#delimg]').live('click',function(){
		var id = $(this).attr('data-id');
		if(id){
			$('#image1_is_del').val(','+id);
		}
		$(this).parent('.photo_p').remove();
	});
});

function setImageSort(obj){
	n = obj.parent('div.photoInfoBox').children('.photo_p');
	n.each(function(i,n){
		$(this).find('input.image_sort').val(i);
	});
}
function appPhoto(num,data){
	var str = '<p class="photo_p">';
		str+= '    <label>'+ data.save_name+'.'+ data.extension +'</label>';
		str+= '    <a href="#delimg" class="del" data-id="">删除</a><br />';
        str+= '    <textarea rows="1" cols="1" class="medium_input" style="float:left;max-width:500px;height:60px" name="image'+num+'_new[alt][]"></textarea>';
		str+= '    <span class="imgSeat">';
        str+= '         <span class="imgup"><a href="#imgup"><span>&uarr;</span></a></span>';
        str+= '         <span class="imgdown"><a href="#imgdown"><span>&darr;</span></a></span>';
        str+= '    </span>';
        str+= '    <a href="../uploads/temp/'+ data.save_name+'.'+ data.extension +'" target="_blank" class="imga"><img src="../uploads/temp/'+ data.save_name+'.'+ data.extension +'"" alt="" style="height:60px;" /></a>';
        str+= '    <input type="hidden" name="image'+num+'_new[save_name][]" value="'+data.save_name+'" />';
		str+= '    <input type="hidden" name="image'+num+'_new[extension][]" value="'+data.extension+'" />';
		str+= '    <input type="hidden" name="image'+num+'_new[file_name][]" value="'+data.file_name+'" />';
		str+= '    <input type="hidden" class="image_sort" name="image'+num+'_new[sort][]" value="'+$('.photo_p').size()+'" />';
        str+= '</p>';
	return str;
}
</script>