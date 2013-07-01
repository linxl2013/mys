<?php
class captcha
{
	function CreateImage ($x,$y,$str){
		$res = ImageCreate($x,$y);
		$bgcolor = ImageColorAllocate($res, 70,70,70);
		$color = ImageColorAllocate($res,172,172,102);
		$black = ImageColorAllocate($res,239,0,59);
		//干扰线
		for($i=0;$i<10;$i++){
			ImageLine($res,rand(1,200),rand(1,40),rand(1,30),rand(1,50),$color);
		}
		//干扰点	
		for($i=0;$i<50;$i++){
			ImageSetPixel($res,rand(1,200),rand(1,20),$black);
		}		
		
		ImageString($res,4,2,5,$str,$black);
		return $res;
	}

	function SetStr (){
		$num = rand(1000,9999);
		$str = (string)$num;
		$str = $str[0]." ".$str[1]." ".$str[2]." ".$str[3];
		return array("str"=>$str,"num"=>$num);
	}
}

?>
