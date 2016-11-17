<?php
	//Smarty信息的初始化类
	class Tpl extends Smarty{
		public function __construct(){
			parent::__construct(); //构造父类
			//初始化Smarty对象中属性：
			$this->template_dir = "view";		//smarty模板目录
			$this->compile_dir = "view_c";		//smarty模板编译目录

			$this->config_dir = "configs";	//smarty配置文件目录

			$this->cache_dir = "cache";		//smarty模板静态缓存目录
			//$this->caching = true;			//是否开启静态缓存
			//$this->cache_lifetime = 3600;		//静态缓存时间（秒）

			//指定定界符
			$this->left_delimiter="{";	//左定界符
			$this->right_delimiter="}";	//右定界符
		}
	}