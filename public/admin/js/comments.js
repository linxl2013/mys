// JavaScript Document

function del(str,url){
	if(confirm(str)){
		location.href=url;
	}
}

function checkFeild(form,value,failmsg){
	if(value==""){
		alert(failmsg);
		return false;	
	}	
	return true;
}
/*JavaScript检查是否为整数
JavaScript正则验证检查输入对象的值是否符合整数格式
输入量是str 输入的字符串
如果输入量字符串str通过验证返回true,否则返回false*/
function isInteger( str ){
	var regu = /^[-]{0,1}[0-9]{1,}$/;
	return regu.test(str);
}

//是否属性设置
function booleanChg(id, table, field, cachename){
	var src = $('#'+field+'_'+id+'_img').attr('src');
	var val = (src=='/admin/images/approve.png')?0:1;
	$.ajax({
		type: "POST",
		url: "/admin/index/booleanChg",
		data: {id:id, table:table, field:field, val:val, cachename:cachename},
		cache: false,
		dataType: 'json',
		success: function(msg){
			if(msg.success){
				if(val==0){
					$('#'+field+'_'+id+'_img').attr('src','/admin/images/cross.png');
				}else{
					$('#'+field+'_'+id+'_img').attr('src','/admin/images/approve.png');
				}
			}else{
				alert( "Server Error: " + msg.info );
			}
		}
	});
}

//子页面图片预览快捷键
function PreViewImagekeyUp(e){
	var currKey=0,e=e||event;
	currKey=e.keyCode||e.which||e.charCode;
	switch(currKey){
		case 27:
			window.parent.Dialog.closePreViewImage(false);
			document.onkeyup = null;
			break;
		case 37:
			window.parent.Dialog.prevImg(false);
			break;
		case 39:
			window.parent.Dialog.nextImg(false);
			break;
		default:
			return false;
	}
}