<!-- kindeditor start -->
<script type="text/javascript" src="../public/editor/kindeditor-min.js"></script>
<script type="text/javascript" src="../pubic/editor/lang/zh_CN.js"></script>
<!-- kindeditor end -->
<!--{include file="admin/comm/uploadify.tpl"}-->
<script type="text/javascript">
var editor;
KindEditor.ready(function(K) {
	editor = K.create('#detail', {
		uploadJson : './editor/upload_json.php',
        fileManagerJson : './editor/file_manager_json.php',
        filterMode : false,
		allowFileManager : true
	});
});

var uploadSettings = [];
uploadSettings['image1_file']={
	'multi':true,
	//'uploader' : './uploadify/uploadify.php',
	'onUploadSuccess' : function(file, data, response){
		//alert(data);
		data = $.parseJSON(data);
		if(data.error == 0){
			//$("#image1").html('<a href="../uploads/temp/'+ data.save_name+'.'+ data.extension +'" title="查看图片" target="_blank"><img src="../uploads/temp/'+ data.save_name+'.'+ data.extension +'" width="50" /></a><br /><a href="../uploads/temp/'+ data.save_name+'.'+ data.extension +'" title="查看图片" target="_blank"><img src="<!--{$templateUrl}-->/images/view.gif" /></a>&nbsp;<a href="javascript:void(0)" onClick="delPic(\'image1\')" title="删除图片"><img src="<!--{$templateUrl}-->/images/del.gif" /></a>');
			/*var html=[],i=0;
			html[i++]='<li style="float:left;list-style-type: none;">';
			html[i++]='<a href="../uploads/temp/'+ data.save_name+'.'+ data.extension +'" target="_blank">';
			html[i++]='<img src="../uploads/temp/'+ data.save_name+'.'+ data.extension +'" width="50" />';
			html[i++]='</a>';
			html[i++]='<input type="hidden" name="image1_save_name[]" value="'+data.save_name+'" />';
			html[i++]='<input type="hidden" name="image1_extension[]" value="'+data.extension+'" />';
			html[i++]='<input type="hidden" name="image1_file_name[]" value="'+data.file_name+'" />';
			html[i++]='</li>';*/
			html = appPhoto(1,data);
			$("#image1").append(html);
			//$("#image1").html(html);
		}else{
			alert(data.msg);
		}
	}
}
</script>

        <form action="<!--{$action}-->" method="post" name="form1" id="form1" onsubmit="return formsubmit();">
		<!--{include file="admin/comm/panelsave.tpl"}-->
        <div class="main_content margintop36">
			<table id="main_form" cellpadding="0" cellspacing="0">
                	<tr>
                    	<td width="200">标题</td>
                        <td><input type="text" class="medium_input" name="title" value="<!--{$row.title|default:null}-->" /></td>
                    </tr>
                    <tr>
						<td width="200">发布时间</td>
						<td><input type="text" class="small_input" name="pub_time" value="<!--{$row.pub_time|default:$smarty.now|date_format:'%Y-%m-%d %T'}-->"></td>
					</tr>
					<tr>
						<td width="200">文章分类</td>
						<td>
							<select name="cate_id" class="mytype" id="cate_id">
								<option value="0">==所有分类==</option>
								<!--{foreach $cateList as $cate}-->
									<option value="<!--{$cate.id}-->" <!--{if $row.cate_id|default:0 == $cate.id}-->selected="selected"<!--{/if}-->>|---<!--{$cate.name}--></option>
									<!--{foreach $cate.child  as $chil}-->
									<option value="<!--{$chil.id}-->" <!--{if $row.cate_id|default:0 == $chil.id}-->selected="selected"<!--{/if}-->>|---|---<!--{$chil.name}--></option>
									<!--{/foreach}-->
								<!--{/foreach}-->
							</select>
						</td>
					</tr>
					<tr>
                    	<td width="200">来源</td>
                        <td><input type="text" class="medium_input" name="source" value="<!--{$row.source|default:null}-->" /></td>
                    </tr>
					<tr>
						<td width="200">排序</td>
						<td><input type="text" class="small_input" name="sort" value="<!--{$row.sort|default:0}-->">&nbsp;&nbsp;由大到小排序</td>
					</tr>
					<tr>
						<td width="200">图片</td>
						<td>
							<input name="image1_file" type="file" id="image1_file" size="30" />
							<input name="image1[is_del]" type="hidden" value="0" id="image1_is_del" />
							<div class="photoInfoBox" id="image1" style="width:90%;text-align:left;">
								<!--{foreach $image1|default:null as $item}-->
								<p class="photo_p">
									<label><!--{$item.image}--></label>
									<a href="#delimg" class="del" data-id="<!--{$item.id}-->">删除</a><br />
									<textarea rows="1" cols="1" class="medium_input" style="float:left;max-width:500px;height:60px" name="image1[edit][<!--{$item.id}-->][alt]"><!--{$item.alt}--></textarea>
									<span class="imgSeat">
										<span class="imgup"><a href="#imgup"><span>&uarr;</span></a></span>
										<span class="imgdown"><a href="#imgdown"><span>&darr;</span></a></span>
									</span>
									<a href="#" class="imga"><img src="../<!--{$item.image}-->" alt="" style="height:60px;" /></a>
									<input type="hidden" class="image_sort" name="image1[edit][<!--{$item.id}-->][sort]" value="<!--{$item.sort}-->" />
								</p>
								<!--{/foreach}-->
							</div>
						</td>
					</tr>
                    <tr>
                    	<td width="200">内容</td>
                        <td><textarea id="detail" name="detail" style="width:90%;height:400px;"><!--{$row.detail|default:null}--></textarea></td>
                    </tr>
                    <tr>
                    	<td width="200">摘要</td>
                        <td><input type="text" class="medium_input" name="summary" value="<!--{$row.summary|default:null}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">关键字</td>
                        <td><textarea name="keyword" class="medium_input" style="height:60px;"><!--{$row.seo_key|default:null}--></textarea></td>
                    </tr>
                    <tr>
                    	<td width="200">描述</td>
                        <td><textarea name="description" class="medium_input" style="height:90px;"><!--{$row.seo_desc|default:null}--></textarea></td>
                    </tr>
                </table>
                <div class="main_bottom">
                	<div class="main_submit">
                    <input type="hidden" name="id" value="<!--{$row.id|default:0}-->" />
                	<input id="subSubmit" type="submit" value="保 存" />
                    <input id="subReset" type="button" onclick="history.back()" value="返 回" />
                    </div>
                </div>
        </div>
        </form>
        <script type="text/javascript">
        function formsubmit(){
        	return true;
        }
        </script>