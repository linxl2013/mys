<?php
function buildTitle($paneltitle){
	$titlemun = 0;
	$html = array();
	if(!empty($paneltitle)){
		$titlemun = 0;
		foreach($paneltitle as $k=>$v){
			if($titlemun>0) $html[] = ' &gt;&gt; ';
			if(is_int($k)) $html[] = $v; 
			else{
				$html[] = '<a href="'.$v.'">';
				$html[] = $k;
        		$html[] = '</a>';	
				$titlemun++;
			}
		}
	}
	return implode('', $html);
}

function buildButton($panelbutton){
	$html = array();
	if(!empty($panelbutton)){
		foreach($panelbutton as $k=>$v){
			$html[] = '<input class="titlebutton" type="button" value="';
			$html[] = $k;
			$html[] = '"  onclick="location.href=\'';
			$html[] = $v;
			$html[] = '\'"/>';
		}
	}
	return implode('', $html);
}
?>