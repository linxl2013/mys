			<!--{include file="admin/comm/paneltop.tpl"}-->
			<form action="" method="get" name="form2" id="form2">
            <div class="main_content margintop36">
            	<table id="main_table" cellpadding="0" cellspacing="0" >
                	<thead>
                    	<tr>
                        	<td width="20"><input type="checkbox" value="" id="check_all" /></td>
                        	<td width="80">ID</td>
                            <td>用户名</td>
                            <td width="150">创建时间</td>
                            <td width="150">最后登陆时间</td>
                            <td width="120">最后登录IP</td>
                            <td width="100" class="last">操作</td>
                        </tr>
                    </thead>
                    <tbody>
                    <!--{foreach $list as $item}-->
                		<tr>
                        	<td><!--{if $item.id!=1}--><input type="checkbox" name="id[]" value="<!--{$item.id}-->" /><!--{else}-->&nbsp;<!--{/if}--></td>
                    		<td><!--{$item.id}--></td>
                            <td><!--{$item.username}--></td>
                            <td><!--{$item.add_time|date_format:'%Y-%m-%d %T'}--></td>
                            <td><!--{$item.last_login|date_format:'%Y-%m-%d %T'}--></td>
                            <td><!--{$item.last_ip}--></td>
                            <td class="last">
                            	<a href="admin.php?action=edit&id=<!--{$item.id}-->" title="编辑"><img src="<!--{$assets}-->/images/pencil.png" alt="编辑" /></a>
								<!--{if $item.locked<2}-->
                                <a href="javascript:del('确定删除该数据？','admin.php?action=delete&id=<!--{$item.id}-->')" title="删除"><img src="<!--{$assets}-->/images/delete.png" alt="删除" /></a>
								<!--{/if}-->
                            </td>
                    	</tr>
                    <!--{foreachelse}-->
                    	<tr>
                        	<td colspan="7" class="last">暂无记录</td>
                        </tr>
                    <!--{/foreach}-->
                    </tbody>
                </table>
                
                <div class="main_bottom">
                    <ul class="page">
                    	
                    </ul>                   
                    <span class="main_select">
                        <select name="action" id="sel_action">
                            <option value="delete">设置为删除</option>
                        </select>
                    </span>
                    <a href="javascript:;" onclick="checksubmit('form2','sel_action')" class="main_button">执行选择</a>
                </div>
            </div>
            </form>