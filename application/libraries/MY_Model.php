<?php
/**
 * 基类模型,实现代码提示功能，积累模型基本上满足了常用查询，如果有更加方便的查询方法不妨更新到积累模型
 * @author Administrator
 *
 * @property CI_Loader $load
 * @property CI_DB_active_record $db
 * @property CI_Calendar $calendar
 * @property Email $email
 * @property CI_Encrypt $encrypt
 * @property CI_Ftp $ftp
 * @property CI_Hooks $hooks
 * @property CI_Image_lib $image_lib
 * @property CI_Language $language
 * @property CI_Log $log
 * @property CI_Input $input
 * @property CI_Output $output
 * @property CI_Pagination $pagination
 * @property CI_Parser $parser
 * @property CI_Session $session
 * @property CI_Sha1 $sha1
 * @property CI_Table $table
 * @property CI_Trackback $trackback
 * @property CI_Unit_test $unit
 * @property CI_Upload $upload
 * @property CI_URI $uri
 * @property CI_User_agent $agent
 * @property CI_Validation $validation
 * @property CI_Xmlrpc $xmlrpc
 * @property CI_Zip $zip
 * @property CI_Form $form_validation
 */
class MY_Model extends Model{
    var $table = '';//表名
    function MY_Model(){
        parent::Model();
    }
    /**
     * 优化默认的where条件语句
     * $where的表达式有多重意思,
     * 为数字时，表示主键字段id值为$where值,相当于id=$where
     *      使用实例：$where = 1;
     * 为字符串时，表示字符串条件表达式
     *      使用实例：$where = "name='Joe' AND status='boss' OR status='active'";
     * 为数组时，默认为键表示字段，值表示字段值，相当于field=fieldValue,
     *        如果数组值为数组类型则判断第一个元素是否为特殊值，第二个元素为条件值
     *      使用实例：
     *              $where['type'] = 1;
     *              $where['startTime >'] = $time;
     *              $where[] = array('id'=>$id);
     *              $where[] = array('date >' => $date);
     *              $where[] = array('type !=' => $type);
     *              $where[] = array('id', array('in', array(1,2,3,4,5)) );
     *              $where[] = array('title', array('like', '搜索标题', 'before'));
     * 三种条件只能使用一种方式，个人建议使用数组形式，在列表查询时用数组更加灵活限制查询条件
     * @param array|string $where
     */
    function __setWhere($where){
        $where || exit('请输入条件');
        if (is_int($where)){//如果为整数表示为主键
            $where = array('id',$where);
        }elseif (is_string($where)){//字符串条件
            
        }elseif (is_array($where)){//数组条件
            foreach ($where as $k => $v){
                if (is_array($v) && count($v) >= 2 && in_array($v[0], array('in', 'orIn', 'notIn', 'orNotIn', 'like', 'orLike', 'notLike', 'orNotLike')) && is_array($v)){
                    $v[0] == 'in' && $this->db->where_in($k, (array)$v[1]);
                    $v[0] == 'orIn' && $this->db->or_where_in($k, (array)$v[1]);
                    $v[0] == 'notIn' && $this->db->where_not_in($k, (array)$v[1]);
                    $v[0] == 'orNotIn' && $this->db->or_where_not_in($k, (array)$v[1]);
                    //like查询时判断是否传第三个参数，第三个参数代表匹配符位置，默认匹配模式为both
                    if (in_array($v[0], array('like','orLike','notLike','orNotLike'))){
                        $v[2] = isset($v[2]) && in_array((string)$v[2], array('before','after','both')) ? $v[2] : 'both';
                    }
                    $v[0] == 'like' && $this->db->like($k, (string)$v[1],$v[2]);
                    $v[0] == 'orLike' && $this->db->or_like($k, (string)$v[1], $v[2]);
                    $v[0] == 'notLike' && $this->db->not_like($k, (string)$v[1], $v[2]);
                    $v[0] == 'orNotLike' && $this->db->or_not_like($k, (string)$v[1], $v[2]);
                    unset($where[$k]);
                }
            }
        }
        $this->db->where($where);
        return true;
    }
    /**
     * 设置限制条数
     * @param  mix $limit 限制条数，（*：全部，int：条数）
     * @return [type]        [description]
     */
    function __setLimit($limit){
        if (is_int($limit)) {
            $this->db->limit($limit);
        }else if ($limit == '*') {
            
        }
        return true;
    }
    /**
     * 返回指定条件的单条数据
     * @param array $where
     */
    function getData($where = '', $colum = ''){
        if ($colum){
            $this->db->select($colum);
        }
        $this->__setWhere($where);
        $query = $this->db->get($this->table,1);
        return $query -> row_array();
    }
    /**
     * 获取指定条件的列表数据
     * @param array $where
     * @param int $limit 限制条数
     * @param int $offset 偏移量
     * @param mixed $orderby 排序（数组或字符串）
     * @return array
     */
    function getList($where = '', $limit = NULL, $offset = NULL, $colum = '', $orderby = ''){
        $this->__setWhere($where);
        if ($colum){
            $this->db->select($colum);
        }
        if ($orderby){
            $this->db->order_by($orderby);
        }
        $query = $this->db->get($this->table,$limit,$offset);
        $findList = $query -> result_array();
        $list = array();
        foreach ($findList as $v){
            if(isset($v['id'])){
                $list[(int)$v['id']] = $v;
            }else{
                $list[] = $v;
            }
        }
        return $list;
    }
    /**
     * 统计总数
     * @param array $where
     * @return number
     */
    function getCount($where = ''){
        $this->__setWhere($where);
        $this->db->select('count(*) cou');
        $query = $this->db->get($this->table, 1);
        $row = $query ->row_array();
        return (int)$row['cou'];
    }
    /**
     * 增加数据
     * @param array $data
     */
    function add($data = array()){
        $this->db->insert($this->table, $data);
        $insertId= $this->db->insert_id();
        //更新父级金额
        $id = $this->getParentId($data);
        if ($id){
            $this->updateParentMoneys($id);
        }
        return $insertId;
    }
    /**
     * 批量插入数据
     * @param array $data 二维数组
     * @return boolean
     */
    function addBatch($data){
        foreach ($data as $v){
            $this->db->insert($this->table, $v);
        }
        return true;
    }
    /**
     * 修改数据
     * @param mixed $where 条件，若为数组表示数组条件，若为数字表示主键ID
     * @param array $data
     */
    function edit($where = array(), $data = array(), $limit = 1){
        //查询数据
        $findData = $this->getData($where);
        if ($findData){
            $this->__setWhere($findData['id']);
            $this->__setLimit($limit);
            $this->db->update($this->table, $data);
            //更新父级金额
            $parentId = $this->getParentId($findData);
            if ($parentId){
                $this->updateParentMoneys($parentId);
            }
            return $findData['id'];
        }else{
            return false;
        }
    }
    /**
     * 更新或插入
     * @param array $where
     * @param array $data
     * @return Ambigous <object, boolean, mixed, string>
     */
    function upset($where = array(),$data = array()){
        $findData = $this->getData($where);
        if ($findData){
            $this->db->update($this->table, $data, $where, 1);
            return $findData['id'];
        }else{
            $this->db->insert($this->table, array_merge($where, $data));
            $insertId= $this->db->insert_id();
            return $insertId;
        }
    }
    /**
     * 删除数据
     * @param mixed $where 条件，若为数组表示数组条件，若为数字表示主键ID
     * @return boolean
     */
    function del($where = array(), $limit = 1){
        //车查询数据
        $findData = $this->getData($where);
        if ($findData){
            $this->__setWhere($where);
            $this->__setLimit($limit);
            $this->db->delete($this->table);
            //更新父级金额
            $parentId = $this->getParentId($findData);
            if ($parentId){
                $this->updateParentMoneys($parentId);
            }
            return true;
        }else{
            return false;
        }
    }
    /**
     * 设置自增
     * @param mix $where
     * @param string $field
     * @param int $step
     * @return object
     */
    function setInc($where, $field, $step){
        $this->db->set($field, $field.'+'.$step, FALSE);
        return $this->db->update($this->table);
    }
    /**
     * 设置自减
     * @param mix $where
     * @param string $field
     * @param int $step
     * @return object
     */
    function setDec($where, $field, $step){
        $this->db->set($field, $field.'-'.$step, FALSE);
        return $this->db->update($this->table);
    }
    /**
     * 更新父级金额
     * @param int $id
     */
    function updateParentMoneys($id){
    
    }
    /**
     * 获取父级ID
     * @return number
     */
    function getParentId($data = array()){
        return 0;
    }
}