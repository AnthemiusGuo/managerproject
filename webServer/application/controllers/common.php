<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class common extends P_Controller {
	function __construct() {
		parent::__construct(true,'a');
		$this->relates = array();

	}

	function common_list(){
		$this->admin_load_menus();
        $this->buildSearch();

        $this->load->model('lists/Common_list',"listInfo");

        $this->listInfo->setInfo($this->dataModelPrefix.$this->dataModelName,$this->dataModelName.'_list',$this->dataModelName.'_model');

        $this->listInfo->setSearchInfo($this->searchKeys);
        $this->listInfo->quickSearchWhere = $this->quickSearchKeys;
        $this->listInfo->setListInfo($this->listKeys);
		if (isset($this->orderKey)){
			$this->listInfo->orderKey = $this->orderKey;
		}

        $this->listInfo->paged = true;
        $this->listInfo->perPage = 20;
		$this->listInfo->limit = $this->listInfo->perPage;
        $this->listInfo->nowPage = $this->pagination->get_tough_page();

		foreach ($this->relates as $key => $value) {
			$this->listInfo->add_where(WHERE_TYPE_WHERE,$key,$value);
		}
        $this->listInfo->load_data_with_search($this->searchInfo);
        $this->listInfo->is_lightbox = true;

        $this->perPage = 20;
        $config['per_page'] = $this->perPage;
        $config['base_url'] = site_url($this->controller_name.'/'.$this->method_name.'/').'/';

        $this->pagination->initialize($config);
        $this->cur_page = $this->pagination->get_cur_page();

        $this->info_link = $this->controller_name . "/info/".$this->typ."/";
        $this->create_link =  $this->controller_name . "/create/".$this->typ."/";
        $this->deleteCtrl = $this->controller_name;
        $this->deleteMethod = 'doDel/'.$this->typ;
        $this->template->load('default_page', 'common/list_view');
	}

	function info($typ,$id){
        $modelName = 'records/'.(ucfirst($typ)).'_model';

        $this->id = $id;
        $this->load->library('user_agent');
        $this->refer = $this->agent->referrer();

        $this->load->model($modelName,"dataInfo");
        $this->dataInfo->init_with_id($id);

        $this->showNeedFields = $this->dataInfo->buildDetailShowFields();

        $this->infoTitle = $this->dataInfo->buildInfoTitle();

        array_unshift($this->title,$this->dataInfo->field_list['name']->gen_show_value());
        $this->template->load('default_lightbox_info', 'common/info');

    }

	function create($typ,$id=""){
        $this->setViewType(VIEW_TYPE_HTML);
		$modelName = 'records/'.(ucfirst($typ)).'_model';

        $this->load->model($modelName,"dataInfo");
        $this->title_create = $this->dataInfo->title_create;

        $this->createUrlC = $this->controller_name;
        $this->createUrlF = 'doCreate/'.$typ;

        if (isset($this->related_field) && $this->related_field!=''){
            if ($id!=""){
                $this->dataInfo->field_list[$this->related_field]->init($id);
                $this->related_id = $id;
            } else {
                $this->related_field = "";
            }
        }

        $this->createPostFields = $this->dataInfo->buildChangeNeedFields();
        $this->modifyNeedFields = $this->dataInfo->buildChangeShowFields();

        $this->editor_typ = 0;
        $this->template->load('default_lightbox_new', 'common/create_related');
    }

    function edit($typ,$id){
        $this->setViewType(VIEW_TYPE_HTML);

		$modelName = 'records/'.(ucfirst($typ)).'_model';

        $this->createUrlC = $this->controller_name;
        $this->createUrlF = 'doUpdate/'.$typ;

        $this->load->model($modelName,"dataInfo");

        $this->dataInfo->init_with_id($id);

        $this->createPostFields = $this->dataInfo->buildChangeNeedFields();
        $this->modifyNeedFields = $this->dataInfo->buildChangeShowFields();

        $this->editor_typ = 1;
        $this->title_create = $this->dataInfo->gen_editor_title();
        $this->template->load('default_lightbox_edit', 'common/create_related');
    }

    function doCreate($typ){
        $this->setViewType(VIEW_TYPE_JSON);

		$modelName = 'records/'.(ucfirst($typ)).'_model';

        $jsonRst = 1;
        $zeit = time();

        $this->load->model($modelName,"dataInfo");
        $this->createPostFields = $this->dataInfo->buildChangeNeedFields();
        $data = array();
        foreach ($this->createPostFields as $value) {
            $data[$value] = $this->dataInfo->field_list[$value]->gen_value($this->input->post($value));
        }

		foreach ($this->relates as $key => $value) {
			$data[$key] = $value;
		}

        $checkRst = $this->dataInfo->check_data($data);
        if (!$checkRst){
            $jsonRst = -1;
            $jsonData = array();
            $jsonData['err']['id'] = 'creator_'.$this->dataInfo->get_error_field();
            $jsonData['err']['msg'] ='请填写所有星号字段！';
            echo $this->exportData($jsonData,$jsonRst);
            return;
        }
		$data = $this->doSthBeforeInsert($typ,$data);

        $newId = $this->dataInfo->insert_db($data);

        $this->doSthAfterInsert($typ,$data,$newId);

        $jsonData = array();

        $jsonData['newId'] = (string)$newId;

        $this->exportToRefer(1,$jsonData);
    }



    function doUpdate($typ,$id){
        $this->setViewType(VIEW_TYPE_JSON);
		$modelName = 'records/'.(ucfirst($typ)).'_model';

        $jsonRst = 1;
		$jsonData = array();
        $zeit = time();


        $this->load->model($modelName,"dataModel");

        $this->dataModel->init_with_id($id);
        $this->createPostFields = $this->dataModel->buildChangeNeedFields();

        $data = array();
        foreach ($this->createPostFields as $value) {
            $newValue = $this->dataModel->field_list[$value]->gen_value($this->input->post($value));
            if ($newValue!="".$this->dataModel->field_list[$value]->value){
                $data[$value] = $newValue;
            }
        }

        if (empty($data)){
            $jsonRst = -2;
            $jsonData['err']['msg'] ='无变化';
            echo $this->exportData($jsonData,$jsonRst);
            return false;
        }

        $checkRst = $this->dataModel->check_data($data,false);
        if (!$checkRst){
            $jsonRst = -1;

            $jsonData['err']['id'] = 'modify_'.$this->dataInfo->get_error_field();
            $jsonData['err']['msg'] ='请填写所有星号字段！';
            echo $this->exportData($jsonData,$jsonRst);
            return false;
        }
        $zeit = time();

		$data = $this->doSthBeforeUpdate($typ,$data,$id);

        $this->dataModel->update_db($data,$id);

		$this->doSthAfterUpdate($typ,$data,$id);

        $this->exportToRefer(1,$jsonData);
    }

    function doDel($typ,$id){
        $this->setViewType(VIEW_TYPE_JSON);

        $goto_url = $this->controller_name.'/cars';
		$modelName = 'records/'.(ucfirst($typ)).'_model';
        $jsonRst = 1;
        $zeit = time();

        $this->load->model($modelName,"dataModel");
        $this->dataModel->init_with_id($id);
        if (!$this->dataModel->check_can_delete($id)){
            $err = $this->dataModel->getLastError();

            $jsonRst = $err['errNo'];
            $jsonData = array();
            $jsonData['err']['msg'] = $err['msg'];
            echo $this->exportData($jsonData,$jsonRst);
            return;
        }


        $this->dataModel->delete_related($id);
        $this->dataModel->delete_db($id);

        //额外操作
        $this->doSthAfterDelete($typ,$id);

        $this->exportToRefer(1,$jsonData);
    }

	function doSthAfterInsert($typ,$data,$newId){
		//等继承，基类啥都不做
	}

	function doSthBeforeInsert($typ,$data){
		return $data;
	}

	function doSthBeforeUpdate($typ,$data,$id){
		return $data;
	}

	function doSthAfterUpdate($typ,$data,$id){
		//等继承，基类啥都不做
	}

	function doSthAfterDelete($typ,$id){
		//等继承，基类啥都不做
	}
}
