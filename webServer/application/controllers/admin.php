<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."controllers/common.php");

class Admin extends common {
	function __construct() {
		parent::__construct(true,'a');
		$this->load->library('pagination');
	}

	function index(){

        $this->admin_load_menus();
        $this->load->model('lists/User_list',"listInfo");

		$this->listInfo->load_data_with_where();

        $this->listInfo->is_lightbox = true;

        $this->create_link =  $this->controller_name . "/create/user/";

        $this->template->load('default_page', 'common/list_view');
    }



}
