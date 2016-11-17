<?php
	// 自定义变量调节器实现中文截取
	function smarty_modifier_mysubstr($string,$length){
		return mb_substr($string,0,$length,"utf-8");
	}


