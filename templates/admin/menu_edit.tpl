        <form action="<!--{$action}-->" method="post" name="form1" id="form1" onsubmit="return formsubmit();">
		<!--{include file="admin/comm/panelsave.tpl"}-->
        <div class="main_content margintop36">
			<table id="main_form" cellpadding="0" cellspacing="0">
                	<tr>
                    	<td width="200">名称</td>
                        <td><input type="text" class="medium_input" name="name" value="<!--{$menu.name|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td>所属栏目</td>
                        <td>
						<select name="parent_id" class="" id="parent_id">
							<option value="0">==所有分类==</option>
							<!--{foreach from=$menuList item=item}-->
							<option value="<!--{$item.id}-->"<!--{if isset($menu.parent_id) && $menu.parent_id == $item.id}--> selected="selected"<!--{/if}--><!--{if $menu.id|default:0==$item.id}--> disabled<!--{/if}-->>|---<!--{$item.name}--></option>
		    				<!--{foreach from=$item.child item=child}-->
							<option value="<!--{$child.id}-->" <!--{if isset($child.parent_id) && $child.parent_id == $child.id}--> selected="selected"<!--{/if}--><!--{if $menu.id|default:0==$child.id}--> disabled<!--{/if}-->>|---|---<!--{$child.name}--></option>
							<!--{/foreach}-->
							<!--{/foreach}-->
						</select>
                        </td>
                    </tr>
                	<tr>
                    	<td width="200">标志</td>
                        <td><input type="text" class="medium_input" name="code" value="<!--{$menu.code|default:''}-->" /></td>
                    </tr>
                	<tr>
                    	<td width="200">链接</td>
                        <td><input type="text" class="medium_input" name="url" value="<!--{$menu.url|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td>排序</td>
                        <td><input type="text" class="small_input" name="sort" value="<!--{$menu.sort|default:''}-->" />&nbsp;&nbsp;数值大的排前</td>
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