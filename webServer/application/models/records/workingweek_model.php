<?php
include_once(APPPATH."models/record_model.php");

class Workingweek_model extends Record_model {
    public function __construct() {
        parent::__construct('sWorkingweek');
        $this->deleteCtrl = 'project';
        $this->deleteMethod = 'doDel/workingweek';
        $this->edit_link = 'project/edit/workingweek/';
        $this->info_link = 'project/info/workingweek/';

        $this->field_list['_id'] = $this->load->field('Field_mongoid',"id","_id");
        $this->field_list['name'] = $this->load->field('Field_string',"名称","name");

        $this->field_list['orderId'] = $this->load->field('Field_int',"顺序","orderId");
        $this->field_list['packed'] = $this->load->field('Field_bool',"隐藏","packed");
        $this->field_list['isCurrent'] = $this->load->field('Field_bool',"当前周","isCurrent");


        $this->field_list['beginTS'] = $this->load->field('Field_date',"开始","beginTS");
        $this->field_list['endTS'] = $this->load->field('Field_date',"结束","endTS");

    }


    public function gen_list_html($templates){
        $msg = $this->load->view($templates, '', true);
    }
    public function gen_editor(){

    }
    public function buildInfoTitle(){
        return '工作周:'.$this->field_list['name']->gen_show_html();
    }

    public function buildChangeShowFields(){
            return array(
                    array('name','isCurrent'),
                    array('orderId','packed'),
                    array('beginTS','endTS'),
                );
    }

    public function buildDetailShowFields(){
        return array(
                  array('name','isCurrent'),
                  array('orderId','packed'),
                  array('beginTS','endTS'),

                );
    }

    public function cancel_shigong($totalId){
        $targetData = array();
        $yuyuefuwu = $this->data['yuyuefuwu'];
        $jiance = $this->data['jiance'];

        foreach ($totalId as $key => $value) {
            $this_item = $this->field_list['zuizhongfuwu']->real_data[$key];
            $id = $this_item->field_list['xfromId']->value;

            if ($this_item->field_list['xfrom']->value==0){
                //18jiance
                foreach ($jiance as $key => $value) {
                    if ((string)$value['_id']==$id){
                        $targetData['jiance.'.$key.".checked"]=1;
                    }
                }
            } else {
                foreach ($yuyuefuwu as $key => $value) {
                    if ((string)$value['_id']==$id){
                        $targetData['yuyuefuwu.'.$key.".checked"]=1;
                    }
                }
            }
            //xfromId
        }

        $targetData['status'] = 20;
        $this->update_db($targetData);

    }

    public function confirm_book($totalId){
        $yuyuefuwu = array();
        $jiance = array();
        $targetData = array();
        $peijians = array();
        $peijianHas = array();
        $services = array();
        $serviceHas = array();

        $totalPrice = 0;

        foreach ($this->dataModel->field_list['yuyuefuwu']->real_data as $key=>$this_item) {
            $yuyuefuwu[$this_item->id] = $this_item;
        }
        foreach ($this->dataModel->field_list['jiance']->real_data as $key=>$this_item) {
            $jiance[$this_item->id] = $this_item;
        }
        foreach ($this->dataModel->field_list['peijians']->real_data as $key => $value) {
            $peijianHas[$value->field_list['xinghaoId']->value][] = $key;

        }
        foreach ($this->dataModel->field_list['services']->real_data as $key => $value) {
            $serviceHas[$value->field_list['xinghaoId']->value][] = $key;

        }


        foreach ($totalId['yuyuefuwu'] as $key => $this_item) {
            $this_data = $yuyuefuwu[$this_item];
            $targetData[] = array(
                                  '_id'=>new MongoId(),
                                //  'xtyp'=>$this_data->data['xtyp'],
                                 'xfrom'=>1,
                                 'xfromId'=>(string)$this_data->data['_id'],

                                //  'name'=>$this_data->data['name'],
                                //  'suggest'=>$this_data->data['suggest'],
                                //  'peijians'=>$this_data->data['peijians'],
                                //  'services'=>$this_data->data['services'],
                                //  'peijianfei'=>$this_data->data['peijianfei'],
                                //  'gongshifei'=>$this_data->data['gongshifei'],
                                //  'youhui'=>$this_data->data['youhui'],
                                //  'jiage'=>$this_data->data['jiage'],
                                //  'endTS'=>0,

                            );
            $totalPrice+=$this_data->data['jiage'];

            if (!isset($this_data->data['peijians'])){
                $this_data->data['peijians'] = array();
            }
            if (!isset($this_data->data['services'])){
                $this_data->data['services'] = array();
            }

            foreach ($this_data->data['peijians'] as $this_peijian) {
                $this_peijian['xfrom'] = 1;
                $this_peijian['xfromId'] = (string)$this_data->data['_id'];
                if (isset($peijianHas[$this_peijian['xinghaoId']])){
                    $flag = false;
                    foreach ($peijianHas[$this_peijian['xinghaoId']] as $thisOldPeijianId) {
                        $thisOldPeijian = $this->dataModel->field_list['peijians']->real_data[$thisOldPeijianId]->data;
                        if ($thisOldPeijian['xfromId']==$this_peijian['xfromId']){
                            $flag = true;
                            break;
                        }
                    }
                    if ($flag){
                        $peijians[] = $thisOldPeijian;
                    } else {
                        $peijians[] = $this_peijian;
                    }
                } else {
                    $peijians[] = $this_peijian;
                }
            }
            foreach ($this_data->data['services'] as $this_service) {
                $this_service['xfrom'] = 1;
                $this_service['xfromId'] = (string)$this_data->data['_id'];
                if (isset($serviceHas[$this_service['xinghaoId']])){
                    $flag = false;
                    foreach ($serviceHas[$this_service['xinghaoId']] as $thisOldserviceId) {
                        $thisOldservice = $this->dataModel->field_list['services']->real_data[$thisOldserviceId]->data;
                        if ($thisOldservice['xfromId']==$this_service['xfromId']){
                            $flag = true;
                            break;
                        }
                    }
                    if ($flag){
                        $services[] = $thisOldservice;
                    } else {
                        $services[] = $this_service;
                    }
                } else {
                    $services[] = $this_service;
                }
            }
        }
        foreach ($totalId['jiance'] as $key => $this_item) {
            $this_data = $jiance[$this_item];
            $targetData[] = array(
                                  '_id'=>new MongoId(),
                                //  'xtyp'=>$this_data->data['xtyp'],
                                 'xfrom'=>0,
                                 'xfromId'=>(string)$this_data->data['_id'],

                                //  'name'=>$this_data->field_list['typ']->gen_show_value().'检测建议',
                                //  'suggest'=>$this_data->data['suggest'],
                                //  'peijians'=>$this_data->data['peijians'],
                                //  'services'=>$this_data->data['services'],
                                 //
                                //  'peijianfei'=>$this_data->data['peijianfei'],
                                //  'gongshifei'=>$this_data->data['gongshifei'],
                                //  'youhui'=>$this_data->data['youhui'],
                                //  'jiage'=>$this_data->data['jiage'],
                                //  'endTS'=>0,
                            );
            $totalPrice+=$this_data->data['jiage'];
            if (!isset($this_data->data['peijians'])){
                $this_data->data['peijians'] = array();
            }
            foreach ($this_data->data['peijians'] as $this_peijian) {
                $this_peijian['xfromId'] = (string)$this_data->data['_id'];
                if (isset($peijianHas[$this_peijian['xinghaoId']])){
                    $flag = false;
                    foreach ($peijianHas[$this_peijian['xinghaoId']] as $thisOldPeijianId) {
                        $thisOldPeijian = $this->dataModel->field_list['peijians']->real_data[$thisOldPeijianId]->data;
                        if ($thisOldPeijian['xfromId']==$this_peijian['xfromId']){
                            $flag = true;
                            break;
                        }
                    }
                    if ($flag){
                        $peijians[] = $thisOldPeijian;
                    } else {
                        $peijians[] = $this_peijian;
                    }
                } else {
                    $peijians[] = $this_peijian;
                }
            }

            foreach ($this_data->data['services'] as $this_service) {
                $this_service['xfrom'] = 1;
                $this_service['xfromId'] = (string)$this_data->data['_id'];
                if (isset($serviceHas[$this_service['xinghaoId']])){
                    $flag = false;
                    foreach ($serviceHas[$this_service['xinghaoId']] as $thisOldserviceId) {
                        $thisOldservice = $this->dataModel->field_list['services']->real_data[$thisOldserviceId]->data;
                        if ($thisOldservice['xfromId']==$this_service['xfromId']){
                            $flag = true;
                            break;
                        }
                    }
                    if ($flag){
                        $services[] = $thisOldservice;
                    } else {
                        $services[] = $this_service;
                    }
                } else {
                    $services[] = $this_service;
                }
            }

        };

        $data = array();

        //订单确认
        $data['status'] = 30;
        //服务项目
        $data['zuizhongfuwu'] = $targetData;
        //价格
        $data['totalPrice'] = $totalPrice;
        $data['peijians'] = $peijians;
        $data['services'] = $services;
        $this->update_db($data,$this->id);
    }

    function check_package_has_use($packageId,$uid){
        $this->db->where(array('active_id'=>$packageId,'crmId'=>$uid));
        $this->db->where_not_in('status',array(1,11));
        $query = $this->db->get($this->tableName);
        return ($query->num_rows()>0)?false:true;
    }

    function reducePeijian(){
        $orgId = $this->field_list['orgId']->value;
        foreach ($this->field_list['peijians']->real_data as $key => $this_item) {
            $counter = $this_item->field_list['counter']->value;
            $chengben = $this_item->field_list['chengben']->value;
            if ($this_item->field_list['hasHuiku']->toBool()) {
                //有回库记录，需要减掉回库数量
                $counter -= $this_item->field_list['counterhuiku']->value;
            }
            //如果减到0了不记入流水
            if ($counter==0){
                log_message('error', $this->field_list['showId']->value.':peijian:'.$this_item->field_list['xinghaoId']->value.';count 0:'.$counter);
                continue;
            }
            $this->peijianModel->init_with_id($this_item->field_list['xinghaoId']->value);

            $logData = array('bookId'=>$this->id,
                             'bookShowId'=>$this->field_list['showId']->value,
                             'peijianId'=>$this_item->field_list['xinghaoId']->value,
                             'peijiantyp'=>$this_item->field_list['typ']->value,
                             'chengben'=>$this_item->field_list['chengben']->value,
                             'peijianming'=>$this_item->gen_show_value(),
                             'counter'=>$counter,
                             'counterO'=>$this->peijianModel->getCounter($orgId),
                             'chengbenO'=>$this->peijianModel->getChengben($orgId),
                             'orgId'=>$orgId
                             );

            if ($this_item->field_list['isKuaisu']->toBool()){
                //快速出入库不减配件数量

                $this->peijianflowModel->write_log($logData,'快速入库');
                $this->peijianflowModel->write_log($logData,'出库');
                //重新计算配件成本
                if ($chengben!=0){
                    //跳过成本为0的那些
                    $this->peijianModel->calcNewChengben($orgId,$chengben,$counter);
                }

            } else if ($this_item->field_list['isZidai']->toBool()){
                //自带件啥都不计算

            } else {
                //减数量
                $this->peijianModel->reduceRealCount($this_item->field_list['xinghaoId']->value,$orgId,$counter);
                //$bookId,$peijianId,$counter,$orgId,$typ){
                $this->peijianflowModel->write_log($logData,'出库');
            }
            //标记自己为出库
            $this_item->update_db(array('hasChuku'=>1),$this_item->id,$this->id);
        }


    }

    function huikuPeijian($tuipeijian){
        $orgId = $this->field_list['orgId']->value;
        foreach ($this->field_list['peijians']->real_data as $key => $this_item) {
            if (!isset($tuipeijian[$key])){
                continue;
            }

            $counter = $tuipeijian[$key];
            if ($this_item->field_list['hasChuku']->toBool()) {
                //已经出库，要补数量
                $this->peijianModel->addRealCount($this_item->field_list['xinghaoId']->value,$orgId,$counter);
                $logData = array('bookId'=>$this->id,
                             'bookShowId'=>$this->field_list['showId']->value,
                             'peijianId'=>$this_item->field_list['xinghaoId']->value,
                             'peijiantyp'=>$this_item->field_list['typ']->value,
                             'peijianming'=>$this_item->gen_show_value(),
                             'counter'=>$counter,
                             'orgId'=>$orgId,

                             );
                $this->peijianflowModel->write_log($logData,'出库回库');

            } else {
                //尚未出库，只需改自己记录

            }

            $this_item->update_db(array('hasHuiku'=>1,'counterhuiku'=>$counter),$this_item->id,$this->id);
        }

    }

    function yanshou_book(){
        $data = array();

        //订单确认
        $data['status'] = 50;
        $data['yanshouTS'] = time();
        $this->update_db($data,$this->id);
    }

    function pay_book($payMethod){
        $data = array();

        //订单确认
        $data['status'] = 60;
        $data['payTS'] = time();
        $data['payMethod'] = $payMethod;

        $this->update_db($data,$this->id);
    }

    function finish_shigong_book(){
        $data = array();

        $data['status'] = 40;
        $data['shigongFinishTS'] = time();

        $this->update_db($data,$this->id);
    }
}
?>
