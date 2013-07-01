<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>菜单</title>
<link type="text/css" rel="stylesheet" href="<!--{$assets}-->/css/style.css" />
<script type="text/javascript" src="../public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
$(function(){
	var menu_a = $('.active');
	var second = $('.menu_ul_second');
	menu_a.click(function(){
		if($(this).attr('show')=='0'){
			second.slideUp(200,function(){
				$(this).siblings('a').removeClass('hover').addClass('active').attr('show','0');
			});
			$(this).removeClass('active').addClass('hover').attr('show','1').siblings('.menu_ul_second').slideDown(200);
		}
	});
	menu_a.eq(0).click();
});
</script>
</head>
<body>
	<div id="left_main" style="position:absolute;top:0;bottom:0;left:10px;">
    	<div id="menu">
        	<ul id="menu_ul" class="menu_ul">
        	<!--{foreach $menuList as $menu}-->
				<li>
					<a href="#" class="active" show='0'><!--{$menu.name}--></a>
					<ul class="menu_ul_second" style="display:none;">
					<!--{foreach from=$menu.child item=chil}-->
						<li><a href="<!--{$chil.url}-->" target="main"><span></span><!--{$chil.name}--></a></li>
					<!--{/foreach}-->
					</ul>
				</li>
			<!--{/foreach}-->
            </ul>
        </div>
    </div>
</body>
</html>