<?php
//学生信息控制文件(本文件就是将来框架中的控制器C)
    class StuController extends Controller
    {
        // 默认入口方法
        public function index()
        {
            //实例化model类
            $mod = new Model('stu');

            //执行model里的操作
            $list = $mod->select();
            //把结果返回到页面

            $this->assign('list',$list);
            $this->assign('title','学生信息列表');
            //显示的页面
            $this->display('stu/index.html');
        }
        //添加页面
        public function add()
        {
            $this->assign('title','添加学生信息');
            $this->display('stu/add.html');
        }
        //执行添加
        public function insert()
        {
            $mod = new Model('stu');
            $m = $mod->insert();
            if($m>0){
                $this->assign("info","添加成功！");
            }else{
                $this->assign("info","添加失败！");
            }
            $this->assign('title','添加处理结果');
            $this->display('stu/info.html');
        }
        //修改页面
        public function edit()
        {
            $mod = new Model('stu');
            $m = $mod->find($_GET['id']);
            $this->assign('ob',$m);
            $this->assign('title','修改学生信息');
            $this->display('stu/edit.html');
        }
        //执行修改
        public function update()
        {
            $mod = new Model('stu');
            $m = $mod->update();
            if($m>0){
                $this->assign("info","修改成功！");
            }else{
                $this->assign("info","修改失败！");
            }
            $this->assign('title','修改处理结果');
            $this->display('stu/info.html');
        }
        //删除
        public function del()
        {
            $mod = new Model('stu');
            $m = $mod->delete($_GET['id']);
            if($m>0)
            {
                $this->assign('info','删除成功!');
            }
            else
            {
                $this->assign('info','删除失败!');
            }
            $this->assign('title','删除结果');
            $this->display('stu/info.html');
        }
    }