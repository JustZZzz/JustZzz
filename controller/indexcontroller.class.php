<?php
	
	class IndexController extends Controller{
		//默认入口方法
		public function index(){
			$this->assign("title","MVC的测试界面");
			$this->display("index.html");
		}
		public function edit(){
			$this->assign("title","修改");
			$this->display("index.html");
		}
	}