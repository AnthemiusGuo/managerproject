<?php
include_once(APPPATH."models/record_model.php");
class Story_model extends Record_model {
    public function __construct() {
        parent::__construct('pStory');
        $this->title_create = '故事/开发项';
        $this->deleteCtrl = 'calendar';
        $this->deleteMethod = 'doDel/story';
        $this->edit_link = 'calendar/edit/story/';
        $this->info_link = 'calendar/info/story/';

        $this->field_list['_id'] = $this->load->field('Field_mongoid',"id","_id");
        $this->field_list['name'] = $this->load->field('Field_title',"名称","name");
        $this->field_list['desc'] = $this->load->field('Field_text',"细节","desc");
        $this->field_list['solution'] = $this->load->field('Field_text',"解决方案","solution");

        $this->field_list['priority'] = $this->load->field('Field_enum',"优先级","priority");
        $this->field_list['priority']->setEnum(array('C','B','A','S'));

        $this->field_list['system'] = $this->load->field('Field_enum',"系统","system");
        $this->field_list['system']->setEnum(array('前端','后端'));

        $this->field_list['status'] = $this->load->field('Field_enum_colorful',"状态","status");
        $this->field_list['status']->setEnum(array('未启动','等待前置','开发中','测试中','已结','移除'));
        $this->field_list['status']->setColor(array(0=>'default',1=>'danger',2=>'warning',3=>'primary',4=>'success'));


        $this->field_list['projectId'] = $this->load->field('Field_projectid',"所属项目","projectId");
        $this->field_list['versionId'] = $this->load->field('Field_relate_simple_id',"所属版本","versionId");
        $this->field_list['versionId']->set_relate_db('pVersion','_id','name');
        $this->field_list['versionId']->add_where(WHERE_TYPE_WHERE,'packed',0);

        $this->field_list['featureId'] = $this->load->field('Field_relate_simple_id',"所属功能","featureId");
        $this->field_list['featureId']->set_relate_db('pFeature','_id','name');
        $this->field_list['featureId']->add_where(WHERE_TYPE_WHERE,'packed',0);

        $this->field_list['weekId'] = $this->load->field('Field_relate_simple_id',"所在周","weekId");
        $this->field_list['weekId']->set_relate_db('sWorkingweek','_id','name');
        $this->field_list['weekId']->add_where(WHERE_TYPE_WHERE,'packed',0);

        $this->field_list['dueUser'] = $this->load->field('Field_userid',"负责人","dueUser");
        $this->field_list['dueUser']->set_in_typ(array(2,4));

        $this->field_list['storyPoint'] = $this->load->field('Field_float',"故事点","storyPoint");
        $this->field_list['beginTS'] = $this->load->field('Field_date',"开发开始时间","beginTS");
        $this->field_list['endTS'] = $this->load->field('Field_date',"预期完工时间","endTS");
    }

    public function gen_list_html($templates){
        $msg = $this->load->view($templates, '', true);
    }
    public function gen_editor(){

    }

    public function buildInfoTitle(){
        return '故事 :'.$this->field_list['name']->gen_show_html();
    }

    public function buildChangeShowFields(){
            return array(
                    array('featureId','weekId'),
                    array('name','null'),

                    array('system','priority'),
                    array('dueUser','null'),
                    array('desc'),
                    array('solution'),

                    array('status','storyPoint'),
                    array('beginTS','endTS'),

                );
    }

    public function buildDetailShowFields(){
        return array(
            array('featureId','weekId'),
            array('name','null'),
            array('system','priority'),
            array('dueUser','null'),

            array('desc'),
            array('solution'),

            array('status','storyPoint'),
            array('beginTS','endTS'),

        );
    }

    public function do_delete_related($id){
        //用户表，清除店长

    }

    public function get_list_ops(){
        $allow_ops = parent::get_list_ops();

        return $allow_ops;
    }

}
?>
