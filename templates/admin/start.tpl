		<div class="main_title" style="position:fixed;top:0;left:0;right:10px;z-index:9999;">
			<span class="title">
				<!--{$paneltitle}-->
			</span>
		</div>
        <div class="main_content margintop36">
            	<table id="main_form" cellpadding="0" cellspacing="0">
					<tr>
						<td width="150">服务器名称：</td>
						<td><!--{$webinfo.serverName}--></td>
						<td width="150">客户端IP：</td>
						<td><!--{$webinfo.customIP}--></td>
					</tr>
					<tr>
						<td>服务器IP：</td>
						<td><!--{$webinfo.serverIP}--></td>
						<td>服务器端口：</td>
						<td><!--{$webinfo.serverPort}--></td>
					</tr>
					<tr>
						<td>服务器时间：</td>
						<td><!--{$webinfo.serverTime}--></td>
						<td>服务器软件版本：</td>
						<td><!--{$webinfo.serverSofteware}--></td>
					</tr>
					<tr>
						<td>服务器操作系统：</td>
						<td><!--{$webinfo.serverSystem}--></td>
						<td>站点物理路径：</td>
						<td><!--{$webinfo.serverDir}--></td>
					</tr>
					<tr>
						<td>mysql数据库：</td>
						<td><!--{$webinfo.serverMysql}--></td>
						<td>ZEND支持：</td>
						<td><!--{$webinfo.serverZend}--></td>
					</tr>
					<tr>
						<td>上传文件大小限制：</td>
						<td><!--{$webinfo.serverUpfile}--></td>
						<td>图形处理 GD：</td>
						<td><!--{$webinfo.serverGD}--></td>
					</tr>
					<tr>
						<td>安全模式：</td>
						<td><!--{$webinfo.safeMode}--></td>
						<td>安全模式GID：</td>
						<td><!--{$webinfo.safeModeGid}--></td>
					</tr>
					<tr>
						<td>Socket 支持：</td>
						<td><!--{$webinfo.serverSocket}--></td>
						<td>Zlib 支持：</td>
						<td><!--{$webinfo.serverZlib}--></td>
					</tr>
					<tr>
						<td>Gzip 支持：</td>
						<td><!--{$webinfo.serverGzip}--></td>
						<td>编码：</td>
						<td><!--{$webinfo.charset}--></td>
					</tr>
                </table>
                <!--<div class="main_bottom">
                	<div class="main_submit">
                    <input type="hidden" name="action" value="add" />
                    <input type="hidden" name="part_id" value="" />
                	<input id="subSubmit" type="submit" value="保 存" />
                    <input id="subReset" type="reset" value="重 置" />
                    </div>
                </div>-->
        </div>