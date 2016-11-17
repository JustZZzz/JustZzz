<?php
	//Controller的控制基类
	class Controller extends Tpl{
		public function __construct(){
			parent::__construct();
		}
		
		/**
		 *Controller初始化方法(在这个方法里根据参数a的值决定调用对应的方法)
		 *
		 */
		public function init(){
			//获取a参数的值
			$a  = isset($_GET["a"])?$_GET["a"]:"index"; //默认值为index
			//判断当前Controller是否存在此方法
			if(method_exists($this,$a)){
				//调用此方法
				$this->$a();
			}else{
				die("没有找到{$a}对应的方法");
			}
		}
	}