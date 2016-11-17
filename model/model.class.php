<?php
//自定义数据库单表信息操作类Model
//定义一个Model
class Model{
    protected $tabName; //表名
    protected $link=null; //连接资源
    protected $pk = "id"; //表的主键名
    protected $fields=array(); //表字段信息
    protected $where = array(); //封装where条件
    protected $order=null; //排序条件
    protected $limit=null; //分页条件
    
    //构造方法，实现了表名初始化，数据库的连接
    public function __construct($tabName){
        $this->tabName = $tabName;
        //连接数据库
        $this->link = @mysql_connect(HOST,USER,PASS)or die("数据库连接失败！");
        //选择数据库设置编码
        mysql_select_db(DBNAME,$this->link);
        mysql_set_charset("UTF8");
        //调用加载对应表结构信息
        $this->getFields(); 
    }
    
    //加载当前表的字段信息 
    private function getFields(){
        //sql语句
        $sql = "desc {$this->tabName}";
        $result = mysql_query($sql,$this->link);
        //遍历当前表的每个字段。
        while($rows = mysql_fetch_assoc($result)){
            $this->fields[]=$rows['Field']; //获取每个字段名并放到fields属性中
            //判断是否是主键
            if($rows['Key']=="PRI"){
                $this->pk = $rows['Field'];
            }
        }
        mysql_free_result($result);
    }
    
    //统计数据条数的方法
    public function count(){
        $sql = "select count(*) from {$this->tabName}";
        
        //判断并封装where条件
        if(count($this->where)>0){
            $sql.=" where ".implode(" and ",$this->where);
        }
        $result = mysql_query($sql,$this->link);
        //通过结果集的定位取值。
        return mysql_result($result,0,0);
    }
    
    //获取所有数据信息
    public function select(){
        $sql = "select * from {$this->tabName}";
        
        //判断并封装where条件
        if(count($this->where)>0){
            $sql.=" where ".implode(" and ",$this->where);
        }
        //判断封装order排序
        if(!empty($this->order)){
            $sql.=" order by ".$this->order;
        }
        //判断封装limit条件
        if(!empty($this->limit)){
            $sql.=" limit ".$this->limit;
        }
        
        $result = mysql_query($sql,$this->link);
        echo $sql."<br/>";
        //解析数据
        $list = array();
        while($rows = mysql_fetch_assoc($result)){
            $list[]=$rows;
        }
        mysql_free_result($result);
        //清空条件
        $this->where = array(); //封装where条件
        $this->order=null; //排序条件
        $this->limit=null; //分页条件
        
        return $list;
    }
    
    //获取指定的单条数据信息
    public function find($id){
        $sql = "select * from {$this->tabName} where {$this->pk}=".$id;
        $result = mysql_query($sql,$this->link);
        //解析数据
        if($result && mysql_num_rows($result)>0){
            return mysql_fetch_assoc($result); 
        }
        return null;
    }
    //执行添加
    public function insert($data=array()){
        //如果不给参数，则从POST中获取
        if(empty($data)){
            $data=$_POST;
        }
        $fieldlist=array();//封装字段
        $valuelist=array();//封装要添加的值
        //遍历要添加的数据，进行筛选
        foreach($data as $k=>$v){
            //判断是否是有效数据（字段名是否对）
            if(in_array($k,$this->fields)){
                $fieldlist[]=$k;
                $valuelist[]=$v;
            }
        }
        //拼装sql语句
        $sql = "insert into {$this->tabName}(".implode(",",$fieldlist).") values('".implode("','",$valuelist)."')";
        //echo $sql;
        //执行添加
        mysql_query($sql,$this->link);
        //返回结果
        return mysql_insert_id($this->link);
    }
    
    //执行修改
    public function update($data=array()){
        //如果不给参数，则从POST中获取
        if(empty($data)){
            $data=$_POST;
        }
        $valuelist=array();//封装要修改的值
        //遍历要修改的数据，进行筛选
        foreach($data as $k=>$v){
            //判断是否是有效数据（字段名是否对）,且不是主键
            if(in_array($k,$this->fields) && $k!=$this->pk){
                $valuelist[]="{$k}='{$v}'";
            }
        }
     
        //拼装sql语句
        $sql = "update {$this->tabName} set ".implode(",",$valuelist)." where {$this->pk}={$data[$this->pk]}";
        //echo $sql;
        //执行修改
        mysql_query($sql,$this->link);
        //返回结果(影响行数)
        return mysql_affected_rows($this->link);
    }
    
    
    //删除信息方法
    public function delete($id){
        $sql = "delete from {$this->tabName} where {$this->pk}={$id}";
        mysql_query($sql,$this->link);
        //返回影响行数
        return mysql_affected_rows($this->link);
    }
    
    
    //封装where条件
    public function where($where){
        $this->where[]=$where;
        return $this;
    }
    
    //封装order排序
    public function order($order){
        $this->order=$order;
        return $this;
    }
    
    //封装limit分页条件
    public function limit($m,$n=0){
        if($n>0){
            $this->limit="{$m},{$n}";
        }else{
            $this->limit=$m;
        }
        return $this;
    }
    
    //定义一个析构方法用于关闭数据
    public function __destruct(){
        if($this->link){
            mysql_close($this->link);
        }
    }
}