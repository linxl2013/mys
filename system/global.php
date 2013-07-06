<?php
/**
 * 全局函数
 */

 /**字符串替换*/  	 
function strFormat($string, $array){
	foreach ($array as $key => $value) {
		$string = str_replace($key, $value, $string);
	}
	return $string;
}
/**加载序列化文件*/
function loadSeri($file){
	$path = APP_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.$file.'.txt';
	return unserialize(file_get_contents($path));
}

function test($str)	{
	var_dump($str);
	exit;
}
/**特殊符号加反斜杠*/
function setAddSlashes($data){
	if(is_array($data)){
		$data = array_map("setAddSlashes",$data);
	}elseif(is_string($data)){
		$data = addslashes($data);
		//$data = str_replace("_", "\_", $data);
		$data = str_replace("%", "\%", $data);
	}
	return $data;
}
/**除去反斜杠*/
function setSripSlashes($data){
	if(is_object($data)&&!empty($data->attributes)) $data=$data->attributes;
	if(is_array($data)){
		$data = array_map("setSripSlashes",$data);
	}elseif(is_string($data)){
		$data = stripslashes($data);
		//$data = str_replace("\_", "_", $data);
		$data = str_replace("\%", "%", $data);
	}
	return $data;
}

		
	//js跳转
  	function jsAlertAndLocation($msg='', $url='', $target='') {
    	$str = '<script>';
		$str .= $msg != '' ? ('alert("'. $msg .'"); ') : '';
		if($url == '') {
			$str .= 'history.go(-1);';
		}
		else {
			$str .= $target != '' ? ($target .'.') : '';
			$str .= 'location.href="'. $url .'";';
		}
		$str .= '</script>';
		
		echo $str;
  	}

  	//内页显示提示
  	function showMsg($msg, $url="", $time=3, $top='100px', $is_load = 0,$content="") {
    	$str =  '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">'. "\n";
		$str .=  '<html xmlns="http://www.w3.org/1999/xhtml">'. "\n";
		$str .=  '<head>'. "\n";
		$str .=  '<title>系统提示</title>'. "\n";
		$str .=  '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'. "\n";
		$str .=  "<META HTTP-EQUIV='Refresh' CONTENT='$time; URL=$url'>\n";
		$str .=  '<link href="../templates/admin/css/left_top.css" rel="stylesheet" type="text/css">'. "\n";
		echo $is_load == '1' ? '<script charset="utf-8">parent.frames["leftFrame"].location.reload();</script>' : '';
		$str .=  '</head><body class="bg_4">'. "\n";
		$str .=  '<table align="center" cellpadding="0" cellspacing="1" class="divmsg" style="margin-top:'.$top.';"><tr><td class="msg_title">系统提示</td></tr>'. "\n";
		if (empty($url)) {
			$str .=  "<tr><td class='msg_content'>$msg $time 钞钟后将自动实现跳转</td></tr><tr><td class='msg_url'><input type='button' onclick='javascript:history.back()' class='button1' value='立即跳转' /></td></tr></table>\n";
		} else {
			$content = $content ? $content : "您也可以：";
			$str .=  "<tr><td class='msg_content'>$msg $time 钞钟后将自动实现跳转。<br />$content</td></tr><tr><td class='msg_url'><input type='button' onclick=\"location.href='".$url."'\" class='button1' value='立即跳转' /></td></tr></table>\n";
		}
		$str .=  '</body>'. "\n";
		$str .=  '</html>'. "\n";
		die( $str );
	  }
	
	//
	function showWebInfo($v) {
		if($v==1) {
			return'<font color=green><b>√</b></font>&nbsp;<font color=gray>支持</font>';
		}else {
			return'<font color=red><b>×</b></font>&nbsp;<font color=gray>不支持</font>';
		}
	}
	  
	// 找出两个日期相差的天数
	function daysDifference($beginDate, $endDate) {
		//explode the date by "-" and storing to array
		$date_parts1 = explode("-", $beginDate);
		$date_parts2 = explode("-", $endDate);
		//gregoriantojd() Converts a Gregorian date to Julian Day Count
		$start_date = gregoriantojd($date_parts1[1], $date_parts1[2], $date_parts1[0]);
		$end_date = gregoriantojd($date_parts2[1], $date_parts2[2], $date_parts2[0]);
		return $end_date - $start_date;
	}
	
	function headerEncode($str, $encode = 'utf-8') {
		$str = base64_encode($str);
		$str = "=?" . $encode . "?B?" . $str . "?=";
		return $str;
	}
	
	
	function sendEmail($to, $from, $subject, $message, $html = false) {
		$subject = headerEncode($subject);
		if ($html) {
			$headers = 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
			
			// Additional headers
			$headers .= 'To: ' . $to . "\r\n";
			$headers .= 'From: ' . $from . "\r\n";
		} else {
			$headers = 'From: ' . $from . "\r\n" . 'X-Mailer: PHP/' . phpversion();
		}
		
		mail($to, $subject, $message, $headers);
	
	}
	
	// 格式化显示的日期
	function fmdate($format, $timestamp, $convert = 1) {
		$dlang = array(
			'date' => '前,天,昨天,前天,小时,半,分钟,秒,刚才'
		);
		
		$GLOBALS['timeformat'] = "H:i";
		$s = date($format, $timestamp);
		
		$timenow = time();
		if ($convert) {
			$lang = explode(",", $dlang['date']);
			$time = time() - $timestamp;
			if ($timenow >= $timestamp) {
				if ($time > 3600) {
					return '<span title="' . $s . '">' . intval($time / 3600) . '' . $lang[4] . $lang[0] . '</span>';
				} elseif ($time > 1800) {
					return '<span title="' . $s . '">' . $lang[5] . $lang[4] . $lang[0] . '</span>';
				} elseif ($time > 60) {
					return '<span title="' . $s . '">' . intval($time / 60) . '' . $lang[6] . $lang[0] . '</span>';
				} elseif ($time > 0) {
					return '<span title="' . $s . '">' . $time . '' . $lang[7] . $lang[0] . '</span>';
				} elseif ($time == 0) {
					return '<span title="' . $s . '">' . $lang[8] . '</span>';
				} else {
					return $s;
				}
			} elseif (($days = intval(($timenow - $timestamp) / 86400)) >= 0 && $days < 7) {
				if ($days == 0) {
					return '<span title="' . $s . '">' . $lang[2] . '' . date($GLOBALS['timeformat'], $timestamp) . '</span>';
				} elseif ($days == 1) {
					return '<span title="' . $s . '">' . $lang[3] . '' . date($GLOBALS['timeformat'], $timestamp) . '</span>';
				} else {
					return '<span title="' . $s . '">' . ($days + 1) . '' . $lang[1] . $lang[0] . '&nbsp;' . date($GLOBALS['timeformat'], $timestamp) . '</span>';
				}
			} else {
				return $s;
			}
		} else {
			return $s;
		}
	}
	
	// 找不到页面时的提示错误
	function showerror($error) {
		global $smarty;
		
		$smarty->assign('error', $error);
		$smarty->assign('main', 'error/page');
		$smarty->display('page.tpl');
		exit();
	}
	
	// 过滤
	function valConvert($array) {
		$magic_quotes_gpc = get_magic_quotes_gpc();
		if (! $magic_quotes_gpc) {
			if (is_array($array)) {
				foreach ($array as $key => $value) {
					$array[$key] = addslashes($value);
				}
			}
		}
		return $array;
	}
	
	function uploadPathFilter($str) {
		$str = stripslashes($str);
		$str = str_replace("../uploads", "uploads", $str);
		return $str;
	
	}
	
	function getRemoteIP() {
		
		// check to see whether the user is behind a proxy - if so,
		// we need to use the HTTP_X_FORWARDED_FOR address (assuming it's available)
		if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])&&strlen($_SERVER["HTTP_X_FORWARDED_FOR"]) > 0) {
			// this address has been provided, so we should probably use it
			$f = $_SERVER["HTTP_X_FORWARDED_FOR"];
			// however, before we're sure, we should check whether it is within a range 
			// reserved for internal use (see http://tools.ietf.org/html/rfc1918)- if so 
			// it's useless to us and we might as well use the address from REMOTE_ADDR
			$reserved = false;
			
			// check reserved range 10.0.0.0 - 10.255.255.255
			if (substr($f, 0, 3) == "10.") {
				$reserved = true;
			}
			
			// check reserved range 172.16.0.0 - 172.31.255.255
			if (substr($f, 0, 4) == "172." && substr($f, 4, 2) > 15 && substr($f, 4, 2) < 32) {
				$reserved = true;
			}
			
			// check reserved range 192.168.0.0 - 192.168.255.255
			if (substr($f, 0, 8) == "192.168.") {
				$reserved = true;
			}
			
			// now we know whether this address is any use or not
			if (! $reserved) {
				$ip = $f;
			}
		
		}
		
		// if we didn't successfully get an IP address from the above, we'll have to use
		// the one supplied in REMOTE_ADDR
		if (! isset($ip)) {
			$ip = $_SERVER["REMOTE_ADDR"];
		}
		
		// done!
		return $ip;
	
	}
	
	/*截取字符长度，，一汉字相当于2个字符*/
	function CutString($string, $length, $dot = '...') {
		#global $charset;
		#[设置变量]
		$charset = "utf8";
	
		if(strlen($string) <= $length)
		{
			return $string;
		}
	
		$strcut = '';
		if(strtolower($charset) == 'utf8')
		{
			$n = $tn = $noc = 0;
			while ($n < strlen($string))
			{
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126))
				{
					$tn = 1; $n++; $noc++;
				}
				elseif(194 <= $t && $t <= 223)
				{
					$tn = 2; $n += 2; $noc += 2;
				}
				elseif(224 <= $t && $t < 239)
				{
					$tn = 3; $n += 3; $noc += 2;
				}
				elseif(240 <= $t && $t <= 247)
				{
					$tn = 4; $n += 4; $noc += 2;
				}
				elseif(248 <= $t && $t <= 251)
				{
					$tn = 5; $n += 5; $noc += 2;
				}
				elseif($t == 252 || $t == 253)
				{
					$tn = 6; $n += 6; $noc += 2;
				}
				else
				{
					$n++;
				}
	
				if ($noc >= $length)
				{
					break;
				}
	
			}
			if ($noc > $length)
			{
				$n -= $tn;
			}
	
			$strcut = substr($string, 0, $n);
	
		}
		else
		{
			for($i = 0; $i < $length - 3; $i++)
			{
				$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			}
		}
		return $strcut.$dot;
	}

	//分页，参数依次为：记录数量，每页记录，当前页数，链接地址，最大页数，数字分页基数
	function multipage($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10) {
		
		$shownum = $showkbd = FALSE;
		$lang['prev'] = $maxpages ? '<img src="images/news_25.jpg" width="14" height="10" />' : '<img src="images/product_22.png" width="26" height="17" />';
		$lang['next'] = $maxpages ? '<img src="images/news_28.jpg" width="14" height="10" />' : '<img src="images/product_24.png" width="26" height="17" />';
		$maxpages = 0;
		
		$lang['first'] = '';
		$lang['last'] = '';
		
		$multipage = '';
		$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
		$realpages = 1;
		if ($num > $perpage) {
			$offset = 2;
			
			$realpages = @ceil($num / $perpage);
			$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
			
			if ($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if ($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if ($to - $from < $page) {
						$to = $page;
					}
				} elseif ($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}
			
			if ($curpage - $offset > 1 && $pages > $page) {
				if ($lang['first']) {
					$multipage = '<a href="'.$mpurl.'page=1">'. $lang['first'] .'</a> &nbsp;<a href="'.$mpurl.'page=1">'. $lang['prev'] .'</a>';
				} else {
					$multipage = ' &nbsp;<a href="'.$mpurl.'page=1">'. $lang['prev'] .'</a>';
				
	
				}
			} else {
				$multipage = $lang['first'] . " &nbsp;<span>". $lang['prev'] ."</span>&nbsp; " ;
			}
			
			if ($curpage > 1) {
				if ($lang['first']) {
					$multipage = '<a href="'.$mpurl.'page=1">'. $lang['first'] .'</a> &nbsp;<a href="'.$mpurl.'page='.($curpage - 1).'">'.$lang['prev'].'</a> &nbsp;';
				} else {
					$multipage = ' &nbsp;<a href="'.$mpurl.'page='.($curpage - 1).'">'.$lang['prev'].'</a> &nbsp;';
				}
			} else {
				$multipage .= '';
			}
			
			for($i = $from; $i <= $to; $i ++) {
				if ($i == $curpage) {
					$multipage .= '<a href="' . $mpurl . 'page=' . $i . '"><b class="red">' . $i . '</b></a> &nbsp;';
				} else {
					$multipage .= '<a href="' . $mpurl . 'page=' . $i . '">' . $i . '</a> &nbsp;';
				}
			}
			if ($curpage < $pages && ! $simple) {
				if ($lang['last']) {
					$multipage .= '<a href="'.$mpurl.'page='.($curpage + 1).'">'.$lang['next'].'</a> &nbsp;<a href="'.$mpurl.'page='.$pages.'">'. $lang['last'] .'</a>';
				} else {
					$multipage .= '<a href="'.$mpurl.'page='.($curpage + 1).'">'.$lang['next'].'</a> &nbsp;';
				}
			} else {
				$multipage .= "<span>". $lang['next'] . "</span> &nbsp;". $lang['last'] ."&nbsp;";
			}
			
			$multipage = $multipage ? $multipage : '';
		}
		
		$maxpage = $realpages;
		return $multipage;
	}
	
	function pager($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10) {
		$lang['prev'] = '上一页';
		$lang['next'] = '下一页';
		$shownum = $showkbd = FALSE;
		$maxpages = 0;
	
		$lang['first'] = '';
		$lang['last'] = '';
	
		$multipage = '';
		$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
		$realpages = 1;
		if ($num > $perpage) {
			$offset = 2;
				
			$realpages = @ceil($num / $perpage);
			$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
				
			if ($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if ($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if ($to - $from < $page) {
						$to = $page;
					}
				} elseif ($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}
			
			if ($curpage > 1) {
				if ($lang['first']) {
					$multipage = '<a href="'.$mpurl.'page=1">'. $lang['first'] .'</a> &nbsp;<a href="'.$mpurl.'page='.($curpage - 1).'" class="prea">'.$lang['prev'].'</a> &nbsp;';
				} else {
					$multipage = ' &nbsp;<a href="'.$mpurl.'page='.($curpage - 1).'" class="prea">'.$lang['prev'].'</a> &nbsp;';
				}
			} else {
				//$multipage .= '';
			}
			
			for($i = $from; $i <= $to; $i ++) {
				if ($i == $curpage) {
					$multipage .= '<a class="onpage" href="' . $mpurl . 'page=' . $i . '">' . $i . '</a> ';
				} else {
					$multipage .= '<a href="' . $mpurl . 'page=' . $i . '">' . $i . '</a> ';
				}
			}
			
			if ($curpage < $pages && ! $simple) {
				if ($lang['last']) {
					$multipage .= '<a href="'.$mpurl.'page='.($curpage + 1).'" class="next">'.$lang['next'].'</a> &nbsp;<a href="'.$mpurl.'page='.$pages.'">'. $lang['last'] .'</a>';
				} else {
					$multipage .= '<a href="'.$mpurl.'page='.($curpage + 1).'" class="next">'.$lang['next'].'</a> &nbsp;';
				}
			} else {
				//$multipage .= "<span>". $lang['next'] . "</span> &nbsp;". $lang['last'] ."&nbsp;";
			}
				
			$multipage = $multipage ? $multipage : '';
		}
	
		$maxpage = $realpages;
		return $multipage;
	}
	
	//分页，参数依次为：记录数量，每页记录，当前页数，链接地址，最大页数，数字分页基数
	function admin_multipage($num, $perpage, $curpage, $mpurl, $maxpages = 0, $page = 10) {
		$shownum = $showkbd = FALSE;
		$lang['prev'] = '上一页';
		$lang['next'] = '下一页';
		
		$lang['first'] = '首 页';
		$lang['last'] = '尾 页';
		
		$multipage = '';
		$mpurl .= strpos($mpurl, '?') ? '&amp;' : '?';
		$realpages = 1;
		if ($num > $perpage) {
			$offset = 2;
			
			$realpages = @ceil($num / $perpage);
			$pages = $maxpages && $maxpages < $realpages ? $maxpages : $realpages;
			
			if ($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if ($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if ($to - $from < $page) {
						$to = $page;
					}
				} elseif ($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}
			
			if ($curpage - $offset > 1 && $pages > $page) {
				$multipage = '<a href="' . $mpurl . 'page=1" class="first">' . $lang['first'] . '</a> &nbsp;<a href="' . $mpurl . 'page=1" class="first">' . $lang['prev'] . '</a>';
			} else {
				$multipage = $lang['first'] . " &nbsp;" . $lang['prev'] . "&nbsp;";
			}
			
			if ($curpage > 1) {
				$multipage = '<a href="' . $mpurl . 'page=1" class="first">' . $lang['first'] . '</a> &nbsp; <a href="' . $mpurl . 'page=' . ($curpage - 1) . '" class="prev">' . $lang['prev'] . '</a> &nbsp;';
			} else {
				$multipage .= '';
			}
			
			for($i = $from; $i <= $to; $i ++) {
				if ($i == $curpage) {
					$multipage .= '<strong>' . $i . '</strong> &nbsp;';
				} else {
					$multipage .= '<a href="' . $mpurl . 'page=' . $i . '">' . $i . '</a> &nbsp;';
				}
			}
			if ($curpage < $pages) {
				$multipage .= '<a href="' . $mpurl . 'page=' . ($curpage + 1) . '" class="next">' . $lang['next'] . '</a> &nbsp;<a href="' . $mpurl . 'page=' . $pages . '" class="last">' . $lang['last'] . '</a>';
			} else {
				$multipage .= $lang['next'] . " &nbsp;" . $lang['last'] . "&nbsp;";
			}
			
			$multipage = $multipage ? '<div class="page"> &nbsp;' . $multipage . ' &nbsp;</div>' : '';
		}
		$maxpage = $realpages;
		
		return $multipage;
	}
	
	
	//提取编辑框里的内容中自行上传的图片的路径:$contentStr -- 内容字符串, $uploadsImageStr -- 已上传的图片的路径集，以"|"分隔, $toDelImageStr --要删除的图片的路径集，以"|"分隔
	function getImageSrc( $contentStr, $uploadImageStr, $toDelImageStr = '') {
		$imageSrcArr = array();	//保存自行上传的图片的路径数组
		preg_match_all( "/(src|SRC)=[\"|'| ]{0,}(\.\.\/uploads\/(.*)\.(gif|jpg|jpeg|png|bmp))/isU", $contentStr, $imageSrcArr );
		$imageSrcArr = array_unique($imageSrcArr[2]);
		$editorFileStr = implode('|', $imageSrcArr);
		$editorFileStr = str_replace('../uploads/', 'uploads/', $editorFileStr);
		
		//删除编辑框里的内容中因上传错误而残留的已删除图片的图片文件
		if($uploadImageStr) {
			$tmpEditorFileStr = str_replace('../uploads/', 'uploads/', $uploadImageStr);
			$tmpEditorFileStr = substr($tmpEditorFileStr, 0, -1);
			if($tmpEditorFileStrArr = explode('|', $tmpEditorFileStr)) {
				foreach($tmpEditorFileStrArr as $tmp) {
					if(!in_array($tmp, $imageSrcArr)) { @unlink(ROOT_PATH . $tmp);}
				}
			}
		}
		//删除编辑框里的内容中已删除图片的图片文件
		if($toDelImageStr) {
			if($editorFileStrArr = explode('|', $toDelImageStr)) {
				foreach($editorFileStrArr as $tmp) {
					if(!in_array($tmp, $imageSrcArr)) { @unlink(ROOT_PATH . $tmp);}
				}
			}
		}
		
		return $editorFileStr;
	}
	/**
	 * @param str $image  原图路径（包括图片名称与扩展名）
	 * @param str $thumb  缩略图路径（包括图片名称与扩展名）
	 * @param str $type   类型，gif,jpg,jpeg,png,gif
	 * @param str $thumb_width 缩略图片宽度
	 * @param str $thumb_height 缩略图片高度
	 * @return string|boolean
	 */
	function createThumb($image, $thumb, $type = '', $thumb_width = 120, $thumb_height = 120,$backgroundColor="255,255,255"){
		if(!file_exists($image)){
			return flase;
		}
		$srcinfo = getimagesize($image);
		if(false === $srcinfo){
			return false;
		}
		if(empty($type)){
			$type = image_type_to_extension($srcinfo[2],false);
		}
		$type = strtolower($type);
		$scale = min($thumb_width / $srcinfo[0], $thumb_height / $srcinfo[1]);
		/*缩略图的实际大小*/
		if ($scale >= 1) {
			$width  = $srcinfo[0];
			$height = $srcinfo[1];
		} else {
			$width  = (int) ($srcinfo[0] * $scale);
			$height = (int) ($srcinfo[1] * $scale);
		}
		/*计算补白的部分大小*/
		$x = $y = 0;
		if($width > $height)
		{
			$y = ($thumb_height-$height)/2;
		}
		else
		{
			$x = ($thumb_width-$width)/2;
		}
		/*渲染原图*/
		$function = 'ImageCreateFrom' . ($type == 'jpg' ? 'jpeg' : $type);
		$srcimage = $function($image);
		/*创建两张缩略图
		 $thumbimage是以比较缩放图，$realimage是补白后$thumb_width、$thumb_height大小的缩略图*/
		if ($type != 'gif' && function_exists('imagecreatetruecolor')){
			$thumbimage = imagecreatetruecolor($width, $height);
			$realimage = imagecreatetruecolor($thumb_width, $thumb_height);
		}else{
			$thumbimage = imagecreate($width, $height);
			$realimage = imagecreate($thumb_width, $thumb_height);
		}
		$backgroundColorArr = explode(',', $backgroundColor);
		/*透明背景*/
		$background = imagecolorallocate($realimage,$backgroundColorArr[0],$backgroundColorArr[1],$backgroundColorArr[2]);
		imagefill($realimage,0,0,$background);
		imagecolortransparent($realimage,$background);
		/*缩略图片*/
		if (function_exists("ImageCopyResampled"))
		{
			imagecopyresampled($thumbimage, $srcimage, 0, 0, 0, 0, $width, $height, $srcinfo[0], $srcinfo[1]);
		}
		else
		{
			imagecopyresized($thumbimage, $srcimage, 0, 0, 0, 0, $width, $height, $srcinfo[0], $srcinfo[1]);
		}
		/*补白图片*/
		imagecopymerge($realimage, $thumbimage, $x, $y, 0, 0, $width, $height, 100);
		$create_func = 'image' . ($type == 'jpg' ? 'jpeg' : $type);
		$create_func($realimage, $thumb);
		imagedestroy($thumbimage);
		imagedestroy($srcimage);
		imagedestroy($realimage);
		return true;
	}
	
	/**判断数组是否为空**/
	function isArrayEmpty($arr = null){
		if(is_array($arr)){
			foreach($arr as $k=>$v){
				if($v&&!is_array($v)){
					return false;
				}
				$t = isArrayEmpty($v);
				if(!$t){
					return false;
				}
			}
			return true;
		}elseif(!$arr){
			return true;
		}else{
			return false;
		}
	}
	
	/**
	 * 构建url查询参数
	 * @param string $url
	 * @param array $queryArr
	 * @return string
	 */
	function constructQueryString($url,$queryArr){
		if(!is_array($queryArr)){
			return $url;
		}
		$querys = array();
		foreach($queryArr as $key=>$query){
			$querys[] = $key ."=".$query;
		}
		$queryString = implode("&", $querys);
		if(strpos($url, "?") !== false){
			return $url."&".$queryString;
		}else{
			return $url."?".$queryString;
		}
	}
	
?>
