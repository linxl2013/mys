<?php
include_once 'Smarty.class.php';

class MySmarty extends Smarty {
	/** @var string 模板所用layout */
	public $layouts  = false;
	
	public function display($template = NULL, $cache_id = NULL, $compile_id = NULL, $parent = NULL) {
		/** 使用 layout 机制 */
		if ($this->layouts) {
			$this->assign('CONTENT_FOR_LAYOUT', $template);
			parent::display($this->layouts, $cache_id, $compile_id, $parent);
			// 最后的smarty显示处理，调用Smarty原始函数
		} else {
			parent::display($template, $cache_id, $compile_id, $parent);
		}
	}
}
?>