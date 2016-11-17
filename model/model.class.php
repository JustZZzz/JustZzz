<?php
//�Զ������ݿⵥ����Ϣ������Model
//����һ��Model
class Model{
    protected $tabName; //����
    protected $link=null; //������Դ
    protected $pk = "id"; //���������
    protected $fields=array(); //���ֶ���Ϣ
    protected $where = array(); //��װwhere����
    protected $order=null; //��������
    protected $limit=null; //��ҳ����
    
    //���췽����ʵ���˱�����ʼ�������ݿ������
    public function __construct($tabName){
        $this->tabName = $tabName;
        //�������ݿ�
        $this->link = @mysql_connect(HOST,USER,PASS)or die("���ݿ�����ʧ�ܣ�");
        //ѡ�����ݿ����ñ���
        mysql_select_db(DBNAME,$this->link);
        mysql_set_charset("UTF8");
        //���ü��ض�Ӧ��ṹ��Ϣ
        $this->getFields(); 
    }
    
    //���ص�ǰ����ֶ���Ϣ 
    private function getFields(){
        //sql���
        $sql = "desc {$this->tabName}";
        $result = mysql_query($sql,$this->link);
        //������ǰ���ÿ���ֶΡ�
        while($rows = mysql_fetch_assoc($result)){
            $this->fields[]=$rows['Field']; //��ȡÿ���ֶ������ŵ�fields������
            //�ж��Ƿ�������
            if($rows['Key']=="PRI"){
                $this->pk = $rows['Field'];
            }
        }
        mysql_free_result($result);
    }
    
    //ͳ�����������ķ���
    public function count(){
        $sql = "select count(*) from {$this->tabName}";
        
        //�жϲ���װwhere����
        if(count($this->where)>0){
            $sql.=" where ".implode(" and ",$this->where);
        }
        $result = mysql_query($sql,$this->link);
        //ͨ��������Ķ�λȡֵ��
        return mysql_result($result,0,0);
    }
    
    //��ȡ����������Ϣ
    public function select(){
        $sql = "select * from {$this->tabName}";
        
        //�жϲ���װwhere����
        if(count($this->where)>0){
            $sql.=" where ".implode(" and ",$this->where);
        }
        //�жϷ�װorder����
        if(!empty($this->order)){
            $sql.=" order by ".$this->order;
        }
        //�жϷ�װlimit����
        if(!empty($this->limit)){
            $sql.=" limit ".$this->limit;
        }
        
        $result = mysql_query($sql,$this->link);
        echo $sql."<br/>";
        //��������
        $list = array();
        while($rows = mysql_fetch_assoc($result)){
            $list[]=$rows;
        }
        mysql_free_result($result);
        //�������
        $this->where = array(); //��װwhere����
        $this->order=null; //��������
        $this->limit=null; //��ҳ����
        
        return $list;
    }
    
    //��ȡָ���ĵ���������Ϣ
    public function find($id){
        $sql = "select * from {$this->tabName} where {$this->pk}=".$id;
        $result = mysql_query($sql,$this->link);
        //��������
        if($result && mysql_num_rows($result)>0){
            return mysql_fetch_assoc($result); 
        }
        return null;
    }
    //ִ�����
    public function insert($data=array()){
        //����������������POST�л�ȡ
        if(empty($data)){
            $data=$_POST;
        }
        $fieldlist=array();//��װ�ֶ�
        $valuelist=array();//��װҪ��ӵ�ֵ
        //����Ҫ��ӵ����ݣ�����ɸѡ
        foreach($data as $k=>$v){
            //�ж��Ƿ�����Ч���ݣ��ֶ����Ƿ�ԣ�
            if(in_array($k,$this->fields)){
                $fieldlist[]=$k;
                $valuelist[]=$v;
            }
        }
        //ƴװsql���
        $sql = "insert into {$this->tabName}(".implode(",",$fieldlist).") values('".implode("','",$valuelist)."')";
        //echo $sql;
        //ִ�����
        mysql_query($sql,$this->link);
        //���ؽ��
        return mysql_insert_id($this->link);
    }
    
    //ִ���޸�
    public function update($data=array()){
        //����������������POST�л�ȡ
        if(empty($data)){
            $data=$_POST;
        }
        $valuelist=array();//��װҪ�޸ĵ�ֵ
        //����Ҫ�޸ĵ����ݣ�����ɸѡ
        foreach($data as $k=>$v){
            //�ж��Ƿ�����Ч���ݣ��ֶ����Ƿ�ԣ�,�Ҳ�������
            if(in_array($k,$this->fields) && $k!=$this->pk){
                $valuelist[]="{$k}='{$v}'";
            }
        }
     
        //ƴװsql���
        $sql = "update {$this->tabName} set ".implode(",",$valuelist)." where {$this->pk}={$data[$this->pk]}";
        //echo $sql;
        //ִ���޸�
        mysql_query($sql,$this->link);
        //���ؽ��(Ӱ������)
        return mysql_affected_rows($this->link);
    }
    
    
    //ɾ����Ϣ����
    public function delete($id){
        $sql = "delete from {$this->tabName} where {$this->pk}={$id}";
        mysql_query($sql,$this->link);
        //����Ӱ������
        return mysql_affected_rows($this->link);
    }
    
    
    //��װwhere����
    public function where($where){
        $this->where[]=$where;
        return $this;
    }
    
    //��װorder����
    public function order($order){
        $this->order=$order;
        return $this;
    }
    
    //��װlimit��ҳ����
    public function limit($m,$n=0){
        if($n>0){
            $this->limit="{$m},{$n}";
        }else{
            $this->limit=$m;
        }
        return $this;
    }
    
    //����һ�������������ڹر�����
    public function __destruct(){
        if($this->link){
            mysql_close($this->link);
        }
    }
}