			<div class="main_title" style="position:fixed;top:0;left:0;right:10px;z-index:9999;">
				<span class="title">
					<!--{$paneltitle}-->
				</span>
				<!--{$panelbotton}-->
				<span class="hr"></span>
			</div>
			<form action="menu.php" method="get" name="form1" id="form1">
            <div class="main_content margintop36">
            	<table id="main_table" cellpadding="0" cellspacing="0" >
                	<thead>
                    	<tr>
                        	<!--<td width="20"><input type="checkbox" value="" id="check_all" /></td>-->
                        	<td width="100">ID</td>
                            <td>标题</td>
                            <td width="100">排序</td>
                            <td width="100" class="last">操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <!--{foreach $list as $item}-->
                		<tr>
                        	<!--<td><input type="checkbox" name="id[]" value="<!--{$item.id}-->" /></td>-->
                    		<td><b><!--{$item.id}--></b></td>
                            <td><b><!--{$item.name}--></b></td>
                            <td><b><!--{$item.sort}--></b></td>
                            <td class="last">
                            	<a href="article_cate.php?action=edit&id=<!--{$item.id}-->" title="编辑"><img src="<!--{$assets}-->/images/pencil.png" alt="编辑" /></a>
                                <a href="javascript:del('确定删除该数据？','article_cate.php?action=delete&id=<!--{$item.id}-->')" title="删除"><img src="<!--{$assets}-->/images/delete.png" alt="删除" /></a>
                            </td>
                    	</tr>
                    	<!--{foreach $item.child as $child}-->
                    	<tr>
                        	<!--<td><input type="checkbox" name="id[]" value="<!--{$child.id}-->" /></td>-->
                    		<td><!--{$child.id}--></td>
                            <td>----><!--{$child.name}--></td>
                            <td><!--{$child.sort}--></td>
                            <td class="last">
                            	<a href="article_cate.php?action=edit&id=<!--{$child.id}-->" title="编辑"><img src="<!--{$assets}-->/images/pencil.png" alt="编辑" /></a>
                                <a href="javascript:del('确定删除该数据？','article_cate.php?action=delete&id=<!--{$child.id}-->')" title="删除"><img src="<!--{$assets}-->/images/delete.png" alt="删除" /></a>
                            </td>
                    	</tr>
                    	<!--{/foreach}-->
                    <!--{foreachelse}-->
                    	<tr>
                        	<td colspan="4" class="last">暂无记录</td>
                        </tr>
                    <!--{/foreach}-->
                    </tbody>
                </table>
                
                <div class="main_bottom">
                    <ul class="page">
                    	
                    </ul>                   
                    <!--<span class="main_select">
                        <select name="action" id="sel_action">
                            <option value="delete">设置为删除</option>
                        </select>
                    </span>
                    <a href="javascript:;" onclick="checksubmit('form1','sel_action')" class="main_button">执行选择</a>-->
                </div>
            </div>
            </form>