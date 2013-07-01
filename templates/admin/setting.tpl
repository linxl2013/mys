        <form action="?action=update" method="post" name="form1" id="form1">
		<div class="main_title" style="position:fixed;top:0;left:0;right:10px;z-index:9999;">
			<span class="title">
				<!--{$paneltitle}-->
			</span>
			<input class="titlebutton" type="submit" value="保 存" />
		</div>
        <div class="main_content margintop36">
			<table id="main_form" cellpadding="0" cellspacing="0">
                	<tr>
                    	<td width="200">网站名称</td>
                        <td><input type="text" class="medium_input" name="sitename" value="<!--{$setting.sitename|default:''}-->" /></td>
                    </tr>
                	<tr>
                    	<td width="200">网站URL</td>
                        <td><input type="text" class="medium_input" name="siteurl" value="<!--{$setting.siteurl|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">首页标题</td>
                        <td><input type="text" class="medium_input" name="title" value="<!--{$setting.title|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">关键字</td>
                        <td><textarea name="key" class="medium_input" style="height:60px;"><!--{$setting.key|default:''}--></textarea></td>
                    </tr>
                    <tr>
                    	<td width="200">描述</td>
                        <td><textarea name="desc" class="medium_input" style="height:60px;"><!--{$setting.desc|default:''}--></textarea></td>
                    </tr>
                    <tr>
                    	<td width="200">备案号</td>
                        <td><input type="text" class="medium_input" name="icp" value="<!--{$setting.icp|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">后台列表行数</td>
                        <td><input type="text" class="small_input" name="perpage" value="<!--{$setting.perpage|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">电子邮件</td>
                        <td><input type="text" class="medium_input" name="email" value="<!--{$setting.email|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">QQ</td>
                        <td><input type="text" class="medium_input" name="qq" value="<!--{$setting.qq|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">电话</td>
                        <td><input type="text" class="medium_input" name="phone" value="<!--{$setting.phone|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">联系</td>
                        <td><input type="text" class="medium_input" name="contact" value="<!--{$setting.contact|default:''}-->" /></td>
                    </tr>
                    <tr>
                    	<td width="200">版权信息</td>
                        <td><textarea name="copyright" class="medium_input" style="height:60px;"><!--{$setting.copyright|default:''}--></textarea></td>
                    </tr>
                </table>
                <div class="main_bottom">
                	<div class="main_submit">
                	<input id="subSubmit" type="submit" value="保 存" />
                    <input id="subReset" type="reset" value="重 置" />
                    </div>
                </div>
        </div>
        </form>