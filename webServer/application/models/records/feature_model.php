<?php
include_once(APPPATH."models/record_model.php");
class Feature_model extends Record_model {
    public function __construct() {
        parent::__construct('pFeature');
        $this->title_create = '功能';
        $this->deleteCtrl = 'calendar';
        $this->deleteMethod = 'doDel/feature/';
        $this->edit_link = 'calendar/edit/feature/';
        $this->info_link = 'calendar/info/feature/';
//服务简述（解决方法）	问题描述（故障详细描述）	服务建议	一级现象	二级现象	有无故障码	故障码代码
//	故障码内容	配件ID

        $this->field_list['_id'] = $this->load->field('Field_mongoid',"id","_id");

        $this->field_list['name'] = $this->load->field('Field_title',"功能","name",true);
        $this->field_list['status'] = $this->load->field('Field_enum',"状态","status");
        $this->field_list['status']->setEnum(array('思路','计划内','开发中','测试中','已结'));
        $this->field_list['packed'] = $this->load->field('Field_bool',"隐藏","packed");
        $this->field_list['hasArt'] = $this->load->field('Field_bool',"有美术工作","hasArt");

        $this->field_list['hasUI'] = $this->load->field('Field_bool',"有UI工作","hasUI");
        $this->field_list['hasExcel'] = $this->load->field('Field_bool',"有配表","hasExcel");
        $this->field_list['hasCode'] = $this->load->field('Field_bool',"有代码开发","hasCode");

        $this->field_list['dueUser'] = $this->load->field('Field_userid',"负责人","dueUser");
        $this->field_list['dueUser']->set_in_typ(array(1,3,4));

        $this->field_list['desc'] = $this->load->field('Field_text',"描述","desc");
        $this->field_list['projectId'] = $this->load->field('Field_projectid',"所属项目","projectId");
        $this->field_list['versionId'] = $this->load->field('Field_relate_simple_id',"所属版本","versionId");
        $this->field_list['versionId']->set_relate_db('pVersion','_id','name');
        $this->field_list['versionId']->add_where(WHERE_TYPE_WHERE,'packed',0);

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
                array('versionId'),

                    array('name','status'),
                    array('dueUser'),

                    array('desc'),
                    array('hasUI','hasArt'),
                    array('hasCode','hasExcel'),



                    array('beginTS','endTS'),
                    array('realEndTS','packed'),


                );
    }

    public function buildDetailShowFields(){
        return array(
          array('projectId','versionId'),

          array('name','status'),
          array('dueUser'),
          array('hasUI','hasArt'),
          array('hasCode','hasExcel'),
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
