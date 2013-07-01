<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>网站管理登陆</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	background-color: #1D3647;
}
.login_txt{color:#6d6e70;}
.inputbox{width:150px; height:22px; line-height:22px;float:left;}
-->
</style>
</head>
<body style="background:url(<!--{$assets}-->/images/bg.png);" onload="document.getElementById('adminaccount').focus();">
	<div style="width:100%;height:159px;background:#fff url(<!--{$assets}-->/images/header_bg.png);">
    
    </div>
    <div style="width:230px; margin:40px auto;">
    <form name="myform" action="login.php" method="post">
        <table cellSpacing="0" cellPadding="0" width="100%" border="0" height="143" id="table212">
          <tr>
            <td width="80" height="38"><span class="login_txt">管理员：&nbsp;&nbsp; </span></td>
            <td width="150" colspan="2"><input name="adminaccount" id="adminaccount" class="inputbox" value="" size="20"></td>
          </tr>
          <tr>
            <td height="35"><span class="login_txt"> 密 码： &nbsp;&nbsp; </span></td>
            <td colspan="2"><input class="inputbox" type="password" size="20" name="adminpassword"></td>
          </tr>
          <tr>
            <td height="35" ><span class="login_txt">验证码：</span></td>
            <td colspan="2">
            	<input class="inputbox" style="width:50px;" name="captcha" type="text" value="" maxLength="4">
            	<img src="../captcha.php" alt="" style="cursor:pointer;width:62px;height:22px;margin:3px 0 0 5px;float:left;" onclick="this.src='../captcha.php?t=' + (new Date().getTime());" title="点击刷新验证码" />
            </td>
          </tr>
          <tr>
            <td height="35">&nbsp;</td>
            <td><input name="Submit" type="submit" class="button" id="Submit" value="登 陆"> </td>
            <td><input name="cs" type="reset" class="button" id="cs" value="取 消"></td>
          </tr>
        </table>
        <br>
    </form>
    </div>


</body>
</html>