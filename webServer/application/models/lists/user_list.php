<?php
include_once(APPPATH."models/list_model.php");
include_once(APPPATH."models/records/user_model.php");
class User_list extends List_model {
    public function __construct() {
        parent::__construct('uUser');
        parent::init("User_list","User_model");
        $this->quickSearchWhere = array("name","phone");
        $this->is_lightbox = false;
        $this->orderKey = array('typ'=>'asc');
    }

    public function build_list_titles(){
        return array('name','typ','loginName','intro','projectId','projectIds');
    }

    public function build_search_infos(){
        return array('name','loginName');
    }
}
?>
