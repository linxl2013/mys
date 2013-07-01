<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>头部</title>
<link type="text/css" rel="stylesheet" href="<!--{$assets}-->/css/style.css" />
<script type="text/javascript">
function logout(){
	if(confirm("您确定要退出控制面板吗？"))
	top.location = "logout.php";
	return false;
}
</script>
</head>
<body>
<div id="header">
	<div class="main">
    	<div id="header_main">
        	<div id="logo"></div>
            <ul id="header_link_ul">
                <li><!--{$admin_welcome}--></li>
                <li class="hr"></li>
                <li><a href="/admin/members/edit/id/" target="main">个人中心</a></li>
                <li class="hr"></li>
                <li><a href="#" target="_self" onClick="logout();">退出登录</a></li>
                <li class="hr"></li>
                <li><a href="../" target="_blank">首页</a></li>
            </ul>
        </div>
    </div>
</div>
</body>
</html>