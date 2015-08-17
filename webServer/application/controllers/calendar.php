<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
include_once(APPPATH."controllers/common.php");

class Calendar extends common {
	function __construct() {
		parent::__construct(true,'a');
        $this->load->library('pagination');
		$this->relates = array('projectId'=>$this->userInfo->field_list['projectId']->value);
	}

	function index(){
		$this->admin_load_menus();

		$this->template->load('default_page', 'calendar/calendar');
	}

	function version(){
		$this->typ = 'version';
		$this->dataModelPrefix = 'p';

		$this->dataModelName = 'Version';
		$this->searchKeys = array('name','desc');
		$this->quickSearchKeys = array('name','desc');
		$this->listKeys = array('projectId','name','desc','status','beginTS','endTS','realEndTS','packed');
		$this->needProjectId = true;

		// $this->need_plus = 'abiaozhun/baoyang_plus';

		$this->common_list();
	}

	function feature($versionId=""){
		$this->typ = 'feature';
		$this->dataModelPrefix = 'p';

		$this->dataModelName = 'Feature';
		$this->searchKeys = array('name','desc');
		$this->quickSearchKeys = array('name','desc');
		$this->listKeys = array('name','desc','status','dueUser','endTS','realEndTS','packed');

		$this->versionId = $versionId;
		$this->load->model('lists/Version_list',"versionList");

		$this->versionList->add_where(WHERE_TYPE_WHERE,'projectId',$this->userInfo->field_list['projectId']->value);
		$this->versionList->add_where(WHERE_TYPE_WHERE,'packed',0);

        $this->versionList->load_data();
		$this->need_plus = 'calendar/version_list';

		if ($versionId!=""){
			$this->relates['versionId'] = $versionId;
		}
		$this->common_list();
	}

	function story($versionId=""){
		$this->typ = 'story';
		$this->dataModelPrefix = 'p';

		$this->dataModelName = 'Story';
		$this->searchKeys = array('name','desc');
		$this->quickSearchKeys = array('name','desc');
		$this->listKeys = array('weekId','featureId','system','name','desc','status','dueUser','storyPoint','beginTS','endTS');

		$this->versionId = $versionId;
		$this->load->model('lists/Version_list',"versionList");

		$this->versionList->add_where(WHERE_TYPE_WHERE,'projectId',$this->userInfo->field_list['projectId']->value);
		$this->versionList->add_where(WHERE_TYPE_WHERE,'packed',0);

        $this->versionList->load_data();
		$this->need_plus = 'calendar/version_list';

		if ($versionId!=""){
			$this->relates['versionId'] = $versionId;
		}

		$this->common_list();
	}

	function storyByWeek($weekId=""){
		$this->typ = 'story';
		$this->dataModelPrefix = 'p';

		$this->dataModelName = 'Story';
		$this->searchKeys = array('name','desc');
		$this->quickSearchKeys = array('name','desc');
		$this->listKeys = array('versionId','featureId','system','name','desc','status','dueUser','storyPoint','beginTS','endTS');

		$this->weekId = $weekId;
		$this->load->model('lists/Workingweek_list',"weekList");
		$this->weekList->add_where(WHERE_TYPE_WHERE,'packed',0);

        $this->weekList->load_data();
		$this->need_plus = 'calendar/week_list';

		if ($weekId!=""){
			$this->relates['weekId'] = $weekId;
		}

		$this->common_list();
	}

	function actionitem($versionId=""){
		$this->typ = 'actionitem';
		$this->dataModelPrefix = 'p';

		$this->dataModelName = 'Actionitem';
		$this->searchKeys = array('name','desc');
		$this->quickSearchKeys = array('name','desc');
		$this->listKeys = array('versionId','featureId','name','desc','dueUser','priority','status','progress','endTS');
		$this->orderKey = array('status'=>'desc','priority'=>'desc');
		// $this->need_plus = 'abiaozhun/baoyang_plus';
		$this->versionId = $versionId;
		$this->load->model('lists/Version_list',"versionList");

		$this->versionList->add_where(WHERE_TYPE_WHERE,'projectId',$this->userInfo->field_list['projectId']->value);
        $this->versionList->load_data_with_where();
		$this->need_plus = 'calendar/version_list';

		if ($versionId!=""){
			$this->relates['versionId'] = $versionId;
		}

		$this->common_list();
	}

	function actionitemByWeek($weekId=""){
		$this->typ = 'actionitem';
		$this->dataModelPrefix = 'p';

		$this->dataModelName = 'Actionitem';
		$this->searchKeys = array('name','desc');
		$this->quickSearchKeys = array('name','desc');
		$this->listKeys = array('versionId','featureId','name','desc','dueUser','priority','status','progress','endTS');
		$this->orderKey = array('endTS'=>'asc','status'=>'desc','priority'=>'desc');

		$this->weekId = $weekId;
		$this->load->model('lists/Workingweek_list',"weekList");
		$this->weekList->add_where(WHERE_TYPE_WHERE,'packed',0);

        $this->weekList->load_data();
		$this->need_plus = 'calendar/week_list';

		if ($weekId!=""){
			$this->relates['weekId'] = $weekId;
		}

		$this->common_list();
	}

	function week($sub_menu="dev"){
		$this->admin_load_menus();
		$this->sub_menu = $sub_menu;
		$this->load->model('records/Workingweek_model',"currentWeekModel");

		$this->currentWeekModel->init_with_where(array('isCurrent'=>1));
		if (!$this->currentWeekModel->is_inited){
			$this->template->load('default_page', 'calendar/no_woringweek');
			return;
		}

		$this->currentWeekId = $this->currentWeekModel->id;

		$this->sub_menus = array(
            "dev"=>array("name"=>"开发内容","show"=>true),
			"ai"=>array("name"=>"待办事项","show"=>true),
            "diary"=>array("name"=>"日报","show"=>true),
            "weekly"=>array("name"=>"周报","show"=>true),
            // "send"=>array("name"=>"留言反馈"),
        );


        if (isset($this->sub_menus[$sub_menu])){
            $this->now_sub_menu = $sub_menu;
        } else {
            $this->now_sub_menu = "dev";
        }

		$this->load->model('lists/Common_list',"storyList");
        $this->storyList->setInfo('pStory','Story_list','Story_model');
		$this->storyList->add_where(WHERE_TYPE_WHERE,'weekId',$this->currentWeekId);
		$this->storyList->add_where(WHERE_TYPE_WHERE,'projectId',$this->userInfo->field_list['projectId']->value);

		$this->storyList->orderKey = array('endTS'=>'asc','status'=>'desc','priority'=>'desc');

        $this->storyList->load_data_with_where();
		$this->storyList->listKeys = array('versionId','featureId','system','name','desc','status','dueUser','storyPoint','beginTS','endTS');

		$this->load->model('lists/Common_list',"aiList");
        $this->aiList->setInfo('pActionitem','Actionitem_list','Actionitem_model');
		$this->aiList->add_where(WHERE_TYPE_WHERE,'projectId',$this->userInfo->field_list['projectId']->value);
		$this->aiList->add_where(WHERE_TYPE_WHERE,'weekId',$this->currentWeekId);

		$this->aiList->orderKey = array('endTS'=>'asc','status'=>'desc','priority'=>'desc');

        $this->aiList->load_data_with_where();
		$this->aiList->listKeys = array('versionId','featureId','name','desc','dueUser','priority','status','progress','endTS');


		$this->template->load('default_page', 'calendar/week');
	}

	function doSthBeforeInsert($typ,$data){
		switch ($typ) {
			case 'story':
			case 'actionitem':
				//根据feature自动更新版本
				$featureId = $data['featureId'];
				$this->load->model('records/feature_model',"featureModel");
				$this->featureModel->init_with_id($featureId);
				$data['versionId'] = $this->featureModel->field_list['versionId']->value;

				return $data;
				break;
			default:
				return $data;
				break;
		}
	}

	function doSthAfterInsert($typ,$data,$newId){
		$config_null_weekId = '55c31052643fa6ae31c025af';
		$newId = (string)$newId;
		switch ($typ) {
			case 'feature':
				$this->load->model('records/actionitem_model',"aiDataModel");
				$this->load->model('records/story_model',"storyDataModel");

				$new_data = array();

				$new_data['name'] = '策划案';
				$new_data['desc'] =  '';
				$new_data['solution'] =  '';
				$new_data['priority'] = 2;
				$new_data['status'] = 0;

				$new_data['projectId'] = $data['projectId'];
				$new_data['versionId'] = $data['versionId'];
				$new_data['featureId'] = $newId;
				$new_data['weekId'] = $config_null_weekId;

				$new_data['dueUser'] = $data['dueUser'];


				$this->aiDataModel->insert_db($new_data);

				if ($data['hasArt']==1){
					//Actionitem 增加 UI 跟进
					//Story 增加 陪表
					$new_data = array();

					$new_data['name'] = '美术需求';
			        $new_data['desc'] =  '';
			        $new_data['solution'] =  '';
			        $new_data['priority'] = 2;
			        $new_data['status'] = 0;

			        $new_data['projectId'] = $data['projectId'];

			        $new_data['versionId'] = $data['versionId'];

			        $new_data['featureId'] = $newId;
					$new_data['weekId'] = $config_null_weekId;

			        $new_data['dueUser'] = $data['dueUser'];


					$this->aiDataModel->insert_db($new_data);
				}
				if ($data['hasUI']==1){
					//Actionitem 增加 UI 跟进
					//Story 增加 陪表
					$new_data = array();

					$new_data['name'] = '跟进UI';
			        $new_data['desc'] =  '';
			        $new_data['solution'] =  '';
			        $new_data['priority'] = 2;
			        $new_data['status'] = 0;

			        $new_data['projectId'] = $data['projectId'];

			        $new_data['versionId'] = $data['versionId'];

			        $new_data['featureId'] = $newId;
					$new_data['weekId'] = $config_null_weekId;

			        $new_data['dueUser'] = $data['dueUser'];


					$this->aiDataModel->insert_db($new_data);
				}
				if ($data['hasExcel']==1){
					//Story 增加 陪表

					$new_data = array();

					$new_data['name'] = '配表';
			        $new_data['desc'] =  '';
			        $new_data['solution'] =  '';
			        $new_data['priority'] = 2;
			        $new_data['status'] = 0;

			        $new_data['projectId'] = $data['projectId'];

			        $new_data['versionId'] = $data['versionId'];

			        $new_data['featureId'] = $newId;
					$new_data['weekId'] = $config_null_weekId;

			        $new_data['dueUser'] = $data['dueUser'];


					$this->aiDataModel->insert_db($new_data);
				}
				if ($data['hasCode']==1){
					//Story 增加 UI 跟进
					//Story 增加 陪表
					$new_data = array();

					$new_data['name'] = '';
					$new_data['desc'] =  '';
					$new_data['solution'] =  '';
					$new_data['priority'] = 0;
					$new_data['system'] = 0;
					$new_data['status'] = 0;

					$new_data['projectId'] = $data['projectId'];

					$new_data['versionId'] = $data['versionId'];

					$new_data['featureId'] = $newId;
					$new_data['weekId'] = $config_null_weekId;


					$new_data['dueUser'] = '';

					$new_data['storyPoint'] = 0;

					$this->storyDataModel->insert_db($new_data);

					$new_data['system'] = 1;
					$this->storyDataModel->insert_db($new_data);

				}
				break;

			default:
				# code...
				break;
		}
	}

	function doSthBeforeUpdate($typ,$data,$id){
		switch ($typ) {

			case 'story':
			case 'actionitem':
				//根据feature自动更新版本
				if (isset($data['featureId'])){
					$featureId = $data['featureId'];
					$this->load->model('records/feature_model',"featureModel");
					$this->featureModel->init_with_id($featureId);
					$data['versionId'] = $this->featureModel->field_list['versionId']->value;
				}
				return $data;
				break;
			default:
				return $data;
				break;
		}
	}

	function doSthAfterUpdate($typ,$data,$id){
		switch ($typ) {
			case 'feature':
				//根据feature自动更新版本
				if (isset($data['versionId'])){
					$versionId = $data['versionId'];
					$this->load->model('records/actionitem_model',"aiDataModel");
					$this->load->model('records/story_model',"storyDataModel");
					$data = array('versionId'=>$versionId);

					$this->aiDataModel->update_db_by_where($data,array('featureId'=>$id));
					$this->storyDataModel->update_db_by_where($data,array('featureId'=>$id));
				}
				break;

			default:
				# code...
				break;
		}
	}


	function doSthAfterDelete($typ,$id){
		switch ($typ) {
			case 'feature':
				$this->load->model('records/actionitem_model',"aiDataModel");
				$this->load->model('records/story_model',"storyDataModel");
				$this->storyDataModel->delete_db_where(array('featureId'=>$id));
				$this->aiDataModel->delete_db_where(array('featureId'=>$id));

				break;
			default:
				break;
		}
	}

	function calList(){
		$start = $this->input->get('start');
		$end = $this->input->get('end');



		$this->load->model('lists/Common_list',"storyList");
        $this->storyList->setInfo('pStory','Story_list','Story_model');
		// $this->storyList->add_where(WHERE_TYPE_WHERE_LT,'endTS',$end);
		// $this->storyList->add_where(WHERE_TYPE_WHERE_GT,'endTS',$start);

		$this->storyList->add_where(WHERE_TYPE_WHERE,'projectId',$this->userInfo->field_list['projectId']->value);

		$this->storyList->orderKey = array('endTS'=>'asc','status'=>'desc','priority'=>'desc');

        $this->storyList->load_data_with_where();

		$this->load->model('lists/Common_list',"aiList");
        $this->aiList->setInfo('pActionitem','Actionitem_list','Actionitem_model');
		$this->aiList->add_where(WHERE_TYPE_WHERE,'projectId',$this->userInfo->field_list['projectId']->value);
		// $this->aiList->add_where(WHERE_TYPE_WHERE_LT,'endTS',$end);
		// $this->aiList->add_where(WHERE_TYPE_WHERE_GT,'endTS',$start);

		$this->aiList->orderKey = array('endTS'=>'asc','status'=>'desc','priority'=>'desc');

        $this->aiList->load_data_with_where();

		$events = array();
        $i = 0;
		// $this->field_list['status']->setEnum(array('未启动','等待前置','开发中','测试中','已结'));
		$colors = array('#777','#d9534f','#337ab7','#5bc0de','#5cb85c','#777');
        foreach($this->storyList->record_list as  $this_record) {
            $events[] = array(
                        "id"=>$this_record->id,
						"typ"=>'story',
                        "title"=>
							$this_record->field_list['system']->gen_show_value().'开发'.$this_record->field_list['name']->value.
							" @ ".$this_record->field_list['featureId']->gen_show_value().
							" by ".$this_record->field_list['dueUser']->gen_show_value(),

                        "start"=>$this_record->field_list['endTS']->value,
                        "end"=>$this_record->field_list['endTS']->value,
                        "allDay"=>true,
                        "backgroundColor"=>$colors[$this_record->field_list['status']->value]
                //         start: new Date(y, m, d - 5),
                //         end: new Date(y, m, d - 2),
                //         backgroundColor: layoutColorCodes['green']
                //     }
                );
            $i++;
        }
		// $this->field_list['status']->setEnum(array(0=>'未设置',1=>'未启动',2=>'准备',3=>'进行中',4=>'完工'));

		$colors = array('#777','#777','#f0ad4e','#337ab7','#5cb85c','#d9534f');

		foreach($this->aiList->record_list as  $this_record) {
            $events[] = array(
                        "id"=>$this_record->id,
						"typ"=>'actionitem',

                        "title"=>$this_record->field_list['name']->value." @ ".$this_record->field_list['featureId']->gen_show_value().
						" by ".$this_record->field_list['dueUser']->gen_show_value(),

                        "start"=>$this_record->field_list['endTS']->value,
                        "end"=>$this_record->field_list['endTS']->value,
                        "allDay"=>true,
                        "backgroundColor"=>$colors[$this_record->field_list['status']->value]
                //         start: new Date(y, m, d - 5),
                //         end: new Date(y, m, d - 2),
                //         backgroundColor: layoutColorCodes['green']
                //     }
                );
            $i++;
        }
        echo json_encode($events);
	}
}
