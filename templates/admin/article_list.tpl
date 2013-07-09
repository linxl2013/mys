            <!--{include file="admin/comm/paneltop.tpl"}-->
            <form action="" method="get" name="form2" id="form2">
            <div class="main_content margintop36">
            	<table id="main_table" cellpadding="0" cellspacing="0" >
                	<thead>
                    	<tr>
                        	<td width="20"><input type="checkbox" value="" id="check_all" /></td>
                        	<td width="80">ID</td>
                            <td>标题</td>
                            <td>类别</td>
                            <td width="100">排序</td>
                            <td width="120">添加时间</td>
                            <td width="120">编辑时间</td>
                            <td width="100" class="last">操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <!--{foreach $list as $item}-->
                		<tr>
                        	<td><input type="checkbox" name="id[]" value="<!--{$item.id}-->" /></td>
                    		<td><!--{$item.id}--></td>
                            <td><!--{$item.title}--></td>
                            <td><!--{$item.cate_name}--></td>
                            <td><!--{$item.sort}--></td>
                            <td><!--{$item.pub_time|date_format:'%Y-%m-%d %T'}--></td>
                            <td><!--{$item.edit_time|date_format:'%Y-%m-%d %T'}--></td>
                            <td class="last">
                            	<a href="article.php?action=edit&id=<!--{$item.id}-->" title="编辑"><img src="<!--{$assets}-->/images/pencil.png" alt="编辑" /></a>
                                <a href="javascript:del('确定删除该数据？','article.php?action=delete&id=<!--{$item.id}-->&cate_id=<!--{$item.cate_id}-->')" title="删除"><img src="<!--{$assets}-->/images/delete.png" alt="删除" /></a>
                            </td>
                    	</tr>
                    <!--{foreachelse}-->
                    	<tr>
                        	<td colspan="8" class="last">暂无记录</td>
                        </tr>
                    <!--{/foreach}-->
                    </tbody>
                </table>
                
                <div class="main_bottom">
                    <ul class="page">
                    	<!--{$pageBar}-->
                    </ul>                   
                    <span class="main_select">
                        <select name="action" id="sel_action">
                            <option value="delete">设置为删除</option>
                        </select>
                    </span>
                    <input type="hidden" name="cate_id" value="<!--{$smarty.get.cate_id|default:0}-->" />
                    <a href="javascript:;" onclick="checksubmit('form2','sel_action')" class="main_button">执行选择</a>
                </div>
            </div>
            </form>