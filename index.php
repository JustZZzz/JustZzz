<?php
	//网站的主入口程序

	//自动加载类
	function __autoload($name){
		echo $name.'<br>';
		$name = strtolower($name);//转成小写			//indexcontroller
		if(file_exists("./controller/{$name}.class.php")){
			require("./controller/{$name}.class.php");
		}elseif(file_exists("./model/{$name}.class.php")){
			require("./model/{$name}.class.php");
		}elseif(file_exists("./ORG/{$name}.class.php")){
			require("./ORG/{$name}.class.php");
		}elseif(file_exists("./libs/".ucfirst($name).".class.php")){
			require("./libs/".ucfirst($name).".class.php");
		}elseif(file_exists("./libs/sysplugins/{$name}.php")){
			require("./libs/sysplugins/{$name}.php");
		}else{
			die("错误：没有找到对应{$name}类!");
		}
	}
	//数据连接配置文件
	require("./configs/config.php");

	//获取参数m的值，并创建对应的Controller对象
	$mod = isset($_GET['m'])?$_GET['m']:"index";
	//拼装Controller类名
	$classname = ucfirst($mod)."Controller";		//IndexController
	//创建对应的Controller对象
	$controller = new $classname();					//new IndexController

	//执行Controller的初始化（Controller入口）
	$controller->init();