<?php
	/**
	* 网站入口的主Controller类
	*/
	class DemoController extends Controller{
		//默认入口方法
		public function index(){
			$this->assign("title","MVC的测试界面(demo)");
			$this->display("index.html");
		}
	}