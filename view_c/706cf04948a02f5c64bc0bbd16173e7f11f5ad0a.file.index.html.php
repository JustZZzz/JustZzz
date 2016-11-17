<?php /* Smarty version Smarty-3.1.8, created on 2016-11-17 10:24:58
         compiled from "view/stu/index.html" */ ?>
<?php /*%%SmartyHeaderCode:294504708582d14fa7f4de9-92043469%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '706cf04948a02f5c64bc0bbd16173e7f11f5ad0a' => 
    array (
      0 => 'view/stu/index.html',
      1 => 1461584760,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '294504708582d14fa7f4de9-92043469',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'title' => 0,
    'list' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.8',
  'unifunc' => 'content_582d14fa826b57_88537385',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_582d14fa826b57_88537385')) {function content_582d14fa826b57_88537385($_smarty_tpl) {?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>
    </head>
    <body>
        <center>
            <?php echo $_smarty_tpl->getSubTemplate ("stu/menu.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

            <h3>浏览信息</h3>
            <table width="700" border="1">
                <tr>
                    <th>id</th>
                    <th>姓名</th>
                    <th>年龄</th>
                    <th>班级</th>
                    <th>操作</th>
                </tr>
                <?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['list']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['age'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['classid'];?>
</td>
                        <td>
                            <a href="index.php?m=stu&a=del&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">删除</a>
                            <a href="index.php?m=stu&a=edit&id=<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">修改</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </center>
    </body>
</html><?php }} ?>