        <form action="<!--{$action}-->" method="post" name="form1" id="form1" onsubmit="return formsubmit();">
		<!--{include file="admin/comm/panelsave.tpl"}-->
        <div class="main_content margintop36">
			<table id="main_form" cellpadding="0" cellspacing="0">
                	<tr>
                    	<td width="200">用户名</td>
                        <td><input type="text" class="medium_input" name="username" value="<!--{$row.username|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">密码</td>
                        <td><input type="password" class="medium_input" name="password" value="" /> (两处密码留空则不修改密码)</td>
                    </tr>
                    <tr>
                    	<td width="200">重复密码</td>
                        <td><input type="password" class="medium_input" name="confirm_password" value="" /></td>
                    </tr>
                    <tr>
                    	<td width="200">电子邮件</td>
                        <td><input type="text" class="medium_input" name="email" value="<!--{$row.email|default:''}-->" /></td>
                    </tr>
					<!--{if isset($row.id) && $row.id != 1}--> 
					<tr>
						<td width="200">权限(<input type=checkbox name=chkall onClick="checkAll('prefix', this.form, 'actionList')">全选)</td>
						<td>
          
						</td>
					</tr>
					<!--{/if}-->

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