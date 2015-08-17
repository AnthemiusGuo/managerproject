<?php
include_once(APPPATH."models/record_model.php");
class User_model extends Record_model {
    public function __construct() {
        parent::__construct('uUser');
        $this->uname = '';
        $this->uid = 0;

        $this->deleteCtrl = 'admin';
        $this->deleteMethod = 'doDel/user/';
        $this->edit_link = 'admin/edit/user/';
        $this->info_link = 'admin/info/user/';


        $this->field_list['_id'] = $this->load->field('Field_mongoid',"uid","_id");
        $this->field_list['loginName'] = $this->load->field('Field_string',"登录名","loginName",true);
        $this->field_list['regTS'] = $this->load->field('Field_date',"注册时间","regTS");
        $this->field_list['typ'] = $this->load->field('Field_enum',"类型","typ");
        $this->field_list['typ']->setEnum(array(0=>'其他',1=>'版控',2=>'程序',3=>'策划',4=>'项管'));


        $this->field_list['pwd'] = $this->load->field('Field_pwd',"密码","pwd");
        $this->field_list['projectId'] = $this->load->field('Field_projectid',"当前项目","projectId");
        $this->field_list['projectIds'] = $this->load->field('Field_array_projectid',"所有项目","projectIds");


        $this->field_list['name'] = $this->load->field('Field_title',"姓名","name",true);
        $this->field_list['intro'] = $this->load->field('Field_text',"备注","intro");

        $this->field_list['createUid'] = $this->load->field('Field_adminuserid',"创建人","createUid");
        $this->field_list['createTS'] = $this->load->field('Field_ts',"创建时间","createTS");
        $this->field_list['lastModifyUid'] = $this->load->field('Field_adminuserid',"最终编辑人","lastModifyUid");
        $this->field_list['lastModifyTS'] = $this->load->field('Field_ts',"最终编辑时间","lastModifyTS");
    }

    public function buildChangeShowFields(){
            return array(
                    array('name','loginName'),
                    array('pwd','typ'),
                    array('projectIds'),
                    array('intro','projectId'),

                );
    }

    public function buildDetailShowFields(){
        return array(
                  array('name','loginName'),

                  array('projectId','typ'),
                array('projectId','projectIds'),
                  array('intro'),
                );
    }




    public function init_by_uid($uid){
        parent::init($uid);
        if (!is_object($uid)){
            $id = new MongoId($uid);
        } else {
            $id = $uid;
        }
        $this->cimongo->where(array('_id'=>$id));

        $query = $this->cimongo->get($this->tableName);
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            $this->init_with_data($id,$result);
            return 1;
        }
        else
        {
            return -1;
        }
    }

    public function init_with_loginName($loginName){
        $this->cimongo->where(array('loginName'=>$loginName));

        $query = $this->cimongo->get($this->tableName);
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            $this->init_with_data($result['_id'],$result);
            return 1;
        }
        else
        {
            return -1;
        }
    }


    public function init_with_data($id,$data){
        parent::init_with_data($id,$data);

        $this->uid = $id->{'$id'};
        $this->uname = $data['name'];
    }

    public function check_loginName_exist($loginName){
        $this->cimongo->where(array('loginName'=>$loginName));
        $query = $this->cimongo->get($this->tableName);
        if ($query->num_rows() > 0)
        {
            return true;
        } else {
            return false;
        }
    }

    public function reg_user($input){
        // if ($input['email']!='' && $this->check_email_exist($input['email'])){
        //     return -1;
        // }
        if ($input['loginName']!='' && $this->check_loginName_exist($input['loginName'])){
            return -2;
        }
        $this->createPostFields = $this->buildChangeNeedFields();
        $data = array();
        foreach ($this->createPostFields as $key) {
            if (!isset($input[$key])){
                $input[$key] = "";
            }
            $data[$key] = $this->field_list[$key]->gen_value($input[$key]);
        }

        $data['projectId'] = 0;

        $data['regTS'] = time();
        $data['typ'] = 0;
        $zeit = time();
        $data['inviteCode'] = substr(md5($zeit.rand(0,100000)), 5,8);

        $checkRst = $this->check_data($data);
        if (!$checkRst){
            return -1;
        }
        $insert_ret = $this->insert_db($data);

        if (DB_TYPE=="MYSQL"){
            $uid = $insert_ret;
        } else {
            $uid = $insert_ret->{'$id'};
        }

        $data['uid'] = $uid;
        $data['_id'] = $insert_ret;
        $this->init_with_data($insert_ret,$data);

        $this->uid = $uid;
        return 1;
    }


    public function verify_login($loginName,$pwd){

        $this->db->where(array('loginName'=>$loginName));

        $query = $this->db->get($this->tableName);

        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            $real_pwd = $result['pwd'];
            if (strtolower(md5($pwd))==strtolower($real_pwd)){


                $this->init_with_data($result['_id'],$result);
                return 1;
            } else {
                return -2;
            }
        }
        else
        {
            return -1;
        }
    }


    public function forceChangePwd($email,$new_password){
        $data = array(
           'pwd' => strtolower(md5($new_password))
        );
        $this->db->where(array('email'=>$email));
        $this->db->update('uUser', $data);
    }
    public function changePwd($pwd,$pwdNew){

        if (strtolower(md5($pwd))!=strtolower($this->field_list['pwd']->value)){

            return -1;
        }
        $data = array(
           'pwd' => strtolower(md5($pwdNew))
        );

        $this->db->where(array('uid'=>$this->uid));
        $this->db->update('uUser', $data);
        return 1;
    }
    public function gen_list_html($templates){
        $msg = $this->load->view($templates, '', true);
    }
    public function gen_editor(){

    }
    public function buildInfoTitle(){
        return '用户:'.$this->field_list['name']->gen_show_html();
    }
    public function checkHasRelateData(){
        $where_clause = array('crmId' => $this->id );
        $this->db->where($where_clause, TRUE);
        $query = $this->db->get('bBook');
        $num = $query->num_rows();
        if ($num>0) {
            return "book";
        }


        return "null";
    }

}
?>
