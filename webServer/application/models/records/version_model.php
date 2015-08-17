<?php
include_once(APPPATH."models/record_model.php");
class Version_model extends Record_model {
    public function __construct() {
        parent::__construct('pVersion');
        $this->title_create = '版本';
        $this->deleteCtrl = 'calendar';
        $this->deleteMethod = 'doDel/version/';
        $this->edit_link = 'calendar/edit/version/';
        $this->info_link = 'calendar/info/version/';
//服务简述（解决方法）	问题描述（故障详细描述）	服务建议	一级现象	二级现象	有无故障码	故障码代码
//	故障码内容	配件ID

        $this->field_list['_id'] = $this->load->field('Field_mongoid',"id","_id");

        $this->field_list['name'] = $this->load->field('Field_title',"版本名","name",true);
        $this->field_list['status'] = $this->load->field('Field_enum',"状态","status");
        $this->field_list['status']->setEnum(array('计划中','提前开发','正式开发','测试中','已结'));
        $this->field_list['packed'] = $this->load->field('Field_bool',"隐藏","packed");


        $this->field_list['desc'] = $this->load->field('Field_text',"版本描述","desc");
        $this->field_list['projectId'] = $this->load->field('Field_projectid',"所属项目","projectId");

        $this->field_list['beginTS'] = $this->load->field('Field_date',"首版日期","beginTS");
        $this->field_list['endTS'] = $this->load->field('Field_date',"预期结束日期","endTS");
        $this->field_list['realEndTS'] = $this->load->field('Field_date',"实际结束日期","realEndTS");




    }

    public function gen_list_html($templates){
        $msg = $this->load->view($templates, '', true);
    }
    public function gen_editor(){

    }

    public function buildInfoTitle(){
        return $this->title_create.':'.$this->field_list['name']->gen_show_html();
    }

    public function buildChangeShowFields(){
            return array(
                    array('name','status'),
                    array('desc'),
                    array('beginTS','endTS'),
                    array('realEndTS','packed'),


                );
    }

    public function buildDetailShowFields(){
        return array(
          array('projectId'),

          array('name','status'),
          array('desc'),
          array('beginTS','endTS'),
          array('realEndTS','packed'),

                );
    }

    public function do_delete_related($id){
        //用户表，清除店长

    }

    public function get_list_ops(){
        $allow_ops = parent::get_list_ops();

        return $allow_ops;
    }

    public function inc_counter(){
        $this->db->where(array('_id'=>new MongoId($this->id)))->increment($this->tableName,array('hitCounter'=>1));
    }

}
?>
