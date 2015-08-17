<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu {
	public function __construct() {
		$this->all_menus = array();
	}

	private function _load_default_menus(){
		$this->all_menus["index"]=array(
                "menu_array"=>array(
                    "index"=>array(
                        "method"=>"href",
                        "href"=>site_url('index/index'),
                        "name"=>"我的信息",
                        "onclick"=>''
                    ),
                ),
                "default_menu"=>"index",
                "name"=>'个人面板',
                "icon"=>'glyphicon-dashboard',
            );


		$this->all_menus["project"] = array(
            "menu_array"=>array(

                "index"=>array(
                    "method"=>"href",
                    "href"=>site_url('project/index'),
                    "name"=>"项目管理",
                    "onclick"=>''
                ),
				"workingweek"=>array(
						"method"=>"href",
						"href"=>site_url('project/workingweek'),
						"name"=>"开发周管理",
						"onclick"=>''
				),

            ),
            "default_menu"=>"index",
            "name"=>'项目管理',
            "icon"=>'glyphicon-th',
        );
		$this->all_menus["calendar"] = array(
            "menu_array"=>array(
				"version"=>array(
						"method"=>"href",
						"href"=>site_url('calendar/version'),
						"name"=>"版本",
						"onclick"=>''
				),
				"feature"=>array(
						"method"=>"href",
						"href"=>site_url('calendar/feature'),
						"name"=>"功能",
						"onclick"=>''
				),
				"story"=>array(
						"method"=>"href",
						"href"=>site_url('calendar/story'),
						"name"=>"开发项",
						"onclick"=>''
				),
				"storyByWeek"=>array(
						"method"=>"href",
						"href"=>site_url('calendar/storyByWeek'),
						"name"=>"开发项(按周)",
						"onclick"=>''
				),
				"actionitem"=>array(
						"method"=>"href",
						"href"=>site_url('calendar/actionitem'),
						"name"=>"事项",
						"onclick"=>''
				),
				"actionitemByWeek"=>array(
						"method"=>"href",
						"href"=>site_url('calendar/actionitemByWeek'),
						"name"=>"事项(按周)",
						"onclick"=>''
				),
                "week"=>array(
                    "method"=>"href",
                    "href"=>site_url('calendar/week'),
                    "name"=>"本周开发内容",
                    "onclick"=>''
                ),
				"index"=>array(
					"method"=>"href",
					"href"=>site_url('calendar/index'),
					"name"=>"日历",
					"onclick"=>''
				),
            ),
            "default_menu"=>"index",
            "name"=>'开发进展',
            "icon"=>'glyphicon-calendar',
        );
		$this->all_menus["docs"]=array(
				"menu_array"=>array(

					"index"=>array(
						"method"=>"href",
						"href"=>site_url('docs/index'),
						"name"=>"文档",
						"onclick"=>''
					),
					"design"=>array(
						"method"=>"href",
						"href"=>site_url('docs/design'),
						"name"=>"策划案",
						"onclick"=>''
					),
					"misc"=>array(
						"method"=>"href",
						"href"=>site_url('docs/misc'),
						"name"=>"进度及其他文档",
						"onclick"=>''
					),
					// "approveReal"=>array(
					//     "method"=>"href",
					//     "href"=>site_url('admin/approveReal'),
					//     "name"=>"实名认证",
					//     "onclick"=>''
					// ),
					// "role"=>array(
					//     "method"=>"href",
					//     "href"=>site_url('admin/role'),
					//     "name"=>"默认角色设置",
					//     "onclick"=>''
					// ),
				),
				"default_menu"=>"index",
				"name"=>'文档',
				"icon"=>'glyphicon-folder-open',
			);
        $this->all_menus["admin"]=array(
                "menu_array"=>array(

                    "index"=>array(
                        "method"=>"href",
                        "href"=>site_url('admin/index'),
                        "name"=>"人员",
                        "onclick"=>''
                    ),
                    // "approveReal"=>array(
                    //     "method"=>"href",
                    //     "href"=>site_url('admin/approveReal'),
                    //     "name"=>"实名认证",
                    //     "onclick"=>''
                    // ),
                    // "role"=>array(
                    //     "method"=>"href",
                    //     "href"=>site_url('admin/role'),
                    //     "name"=>"默认角色设置",
                    //     "onclick"=>''
                    // ),
                ),
                "default_menu"=>"index",
                "name"=>'网站管理',
                "icon"=>'glyphicon-cog',
            );

	}

	function load_menu($roleId){
		//$this->field_list['typ']->setEnum(array(0=>"普通员工",1=>"技师",2=>"客服",3=>'前台行政',
		// 10=>'店长',99=>'总店经理',999=>'系统管理员'));
		$this->_load_default_menus();
		return $this->all_menus;
	}

}
