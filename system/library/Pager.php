<?php 
final class Pager
{
		public  $pageid=1;
		public  $pagesize;
		public  $totalpage;
		public  $counts;
		public  $frompage;
		public  $btncount=9;
		public $url='';
		public function __construct($url,$count,$pageid=1,$pagesize=10,$groud=false) 
		{
			$this->pageid=$pageid;
			$this->pagesize=$pagesize;
			$this->totalpage = ceil($count/$this->pagesize);
			$this->counts=$count;
			$this->url = $url;
		}
		public function queryString($queryArr)
		{
			if(!is_array($queryArr)){
				return;
			}
			$querys = array();
			foreach($queryArr as $key=>$query){
				$querys[] = $key ."=".$query;
			}
			$queryString = implode("&", $querys);
			if(strpos($this->url, "?") !== false){
				$this->url = $this->url."&".$queryString;
			}else{
				$this->url = $this->url."?".$queryString;
			}
		}
		
		public function setPagesize($pagesize)
		{
			$this->pagesize=$pagesize;
		}
		
		public function setPageid($pageid)
		{
			$this->pageid=$pageid;
			if($pageid==0||$pageid<1||$pageid==''||!is_numeric($pageid)){
				$this->pageid=1;
			}elseif($this->totalpage>1&&$pageid>=$this->totalpage){
				$this->pageid = $this->totalpage;
			}
		}
		public function getPageid()
		{
			return $this->pageid;
		}
		
		public function pageString()
		{
				$pageid=$this->getPageid();
				$totalpage=$this->totalpage;
				$btncount=$this->btncount;
				$numpage='';
				$PrevPage="<li><a href='javascript:;' class='disable'>&lt;&lt; prev</a></li>";
				$NextPage="<li><a href='javascript:;' class='disable'>next &gt;&gt;</a></li>";				
				$IndexPage='';
				$LastdPage='';
				$url=$this->url;
				$url.=strpos($url, '?') ? '&amp;' : '?';
			
				if($pageid==1)
				{
					$IndexPage='';
					if($totalpage>1)
					{
						$NP=$pageid+1;
						$NextPage="<li><a href='{$url}page={$NP}'>next &gt;&gt;</a></li>";
					}
				}else{
					$VP=$pageid-1;
					$PrevPage="<li><a href='{$url}page={$VP}'>&lt;&lt; prev</a></li>";
					if($pageid<$totalpage)
					{
						$NP=$pageid+1;
						$NextPage="<li><a href='{$url}page={$NP}'>next &gt;&gt;</a></li>";
					}
					else
					{
						$LastdPage='';
					}
				}
				
				$i=intval($btncount/2);
				if($totalpage<$btncount){
					$startIndex=1;
					$endIndex=$totalpage;
				}else{
					if($pageid<($i+1)){
						$startIndex=1;
						$endIndex=$btncount;
					}elseif($pageid>$i && $pageid<=$totalpage-$i){
						$startIndex=$pageid-$i;
						$endIndex=$pageid+$i;
					}elseif($pageid>$totalpage-$i){
						$startIndex=$totalpage-$btncount+1;
						$endIndex=$totalpage;
					}
				}
				
				for($i=$startIndex;$i<=$endIndex;$i++)
				{
					if($i==$pageid){
						$numpage.="<li><a href='javascript:;' class='disable'>$i</a></li>";
					}else{
						$numpage.="<li><a href='{$url}page={$i}'>$i</a></li>";
					}
				}
				//$pagestring="<div style=' font-size:12px'>";
				$pagestring=$IndexPage." ".$PrevPage."  {$numpage}  "." ".$NextPage." ".$LastdPage; //." ".$pageid."/".$totalpage."页";
				//$pagestring.="共{$this->counts}条";
				//$pagestring.="</div>";
				return $pagestring;
		}
		
		public function homePageString($pageName, $pageParams=''){
			$dataCount = $this->counts;
			$pageSize = $this->pagesize;
			$pageIndex = $this->pageid;
			$btnCount = $this->btncount;
			$firstPage = $prevPage = $numPage = $nextPage = $lastPage = '';
			
			if($dataCount % $pageSize == 0)
				$pageCount = floor($dataCount/$pageSize);
			else
				$pageCount = floor($dataCount/$pageSize) + 1;

			if($pageIndex < $pageCount){
				$nextPageIndex = $pageIndex + 1;
				$nextPage = "<a href=\"/$pageName/p/$nextPageIndex/$pageParams\">下一页</a>&nbsp;";
			}
			if($pageIndex < $pageCount-1){
				$lastPage = "<a href=\"/$pageName/p/$pageCount/$pageParams\">&gt;&gt;</a>";
			}
			if($pageIndex > 1){
				$prevPageIndex = $pageIndex - 1;
				$prevPage = "<a href=\"/$pageName/p/$prevPageIndex/$pageParams\">上一页</a>&nbsp;";
			}
			if($pageIndex > 2)
				$firstPage = "<a href=\"/$pageName/p/1/$pageParams\">&lt;&lt;</a>&nbsp;";
			
			$i = intval($btnCount / 2);
			if($pageCount < $btnCount){
				$startIndex = 1;
				$endIndex = $pageCount;
			}else{
				if($pageIndex < (i+1)){
					$startIndex = 1;
					$endIndex = $btnCount;
				}elseif($pageIndex > $i && $pageIndex <= $pageCount - $i){
					$startIndex = $pageIndex - $i;
					$endIndex = $pageIndex + $i;
				}elseif($pageIndex > $pageCount - $i){
					$startIndex = $pageCount - $btnCount + 1;
					$endIndex = $pageCount;
				}
			}
				
			for($i=$startIndex; $i<=$endIndex; $i++){
				if($i==$pageIndex)
					$numPage.="<a style=\"font-weight:bold;\">$i</a>&nbsp;";
				else
					$numPage.="<a href=\"/$pageName/p/$i/$pageParams\">$i</a>&nbsp;";
			}
			
			$pageString = '<div style=" font-size:12px">';
			$pageString .= "$firstPage $prevPage  $numPage  $nextPage $lastPage ";
			$pageString .= "</div>";

			return $pageString;
		}
		
		public function page_and_page($count)
		{
			$this->totalpage = ceil($count/$this->pagesize);

			return $this->totalpage;
		}
		
		public function page_from_page()
		{
			$frompage=($this->pageid-1)*$this->pagesize;
			if($frompage<0){$frompage=0;}

			return $frompage;
		}
}		
?>