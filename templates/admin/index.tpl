<!DOCTYPE html>
<html>
<head>
<title>管理中心</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style type="text/css">
body{font-size:12px;}
#admin_index{position:absolute;left:0;right:0;top:0;bottom:0;width:100%;height:100%}
#admin_top{position:absolute;left:0;right:0;top:0;height:50px;width:100%;}
#admin_middle{position:absolute;left:0;right:0;top:50px;bottom:51px;}
#admin_left{position:absolute;left:0;right:0;top:0;bottom:0;width:100%;height:100%;}
#admin_main{position:absolute;left:0;right:0;top:0;bottom:0;width:100%;height:100%;}
#admin_bottom{position:absolute;left:0;right:0;bottom:0;height:51px;width:100%}
</style>
</head>
<body>
<div id="admin_index">
	<iframe id="admin_top" name="topFrame" src="index.php?frame=top" scrolling="no" frameborder="0"></iframe>
	<div id="admin_middle">
		<div id="ll" style="position:absolute;top:0;left:0;bottom:0;width:230px;">
        	<iframe id="admin_left" name="leftFrame" src="index.php?frame=left" scrolling="auto" frameborder="0"></iframe>
        </div>
		<div style="position:absolute;top:0;left:230px;bottom:0;right:0;">
			<iframe id="admin_main" name="main" src="index.php?frame=main" scrolling="auto" frameborder="0"></iframe>
		</div>
	</div>
	<iframe id="admin_bottom" src="index.php?frame=bottom" scrolling="no" frameborder="0"></iframe>
</div>
</body>
</html>