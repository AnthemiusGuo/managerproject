<?php
include_once(APPPATH."models/record_model.php");
class Package_model extends Record_model {
    public function __construct() {
        parent::__construct('aPackage');
        $this->deleteCtrl = 'aactive';
        $this->deleteMethod = 'doSubDel/package';
        $this->edit_link = 'aactive/edit/package/';
        $this->info_link = 'aactive/info/package/';

        $this->field_list['_id'] = $this->load->field('Field_mongoid',"id","_id");
        $this->field_list['name'] = $this->load->field('Field_string',"促销礼包名","name");

        $this->field_list['orgId'] = $this->load->field('Field_orgid',"门店","orgId");

        $this->field_list['status'] = $this->load->field('Field_enum',"状态","status");
        $this->field_list['status']->setEnum(array(0=>'测试',10=>'开放',20=>'结束'));

        $this->field_list['typ'] = $this->load->field('Field_enum',"预约类型","typ");
        $this->field_list['typ']->setEnum(array(0=>'无法确定',10=>'维修类',20=>'保养类',30=>'美容装潢类',40=>'事故钣金喷漆'));

        $this->field_list['limit_typ'] = $this->load->field('Field_enum',"限制类型","limit_typ");
        $this->field_list['limit_typ']->setEnum(array(0=>'无限制',10=>'共X个',20=>'每天X个'));

        $this->field_list['limit_size'] = $this->load->field('Field_float',"限制个数","limit_size");
        $this->field_list['limit_counter'] = $this->load->field('Field_float',"当前剩余个数","limit_counter");
        $this->field_list['limit_chepinpai'] = $this->load->field('Field_array_plain',"限制车品牌","limit_chepinpai");
        $this->field_list['limit_chepinpai']->tips = "[\"品牌id1\",\"品牌id2\"]";

        $this->field_list['limit_desc'] = $this->load->field('Field_string',"参加条件","limit_desc");
        $this->field_list['limit_desc']->tips = "界面上显示的是这个字段，纯文字描述";

        $this->field_list['bookdesc'] = $this->load->field('Field_text',"预约内容","bookdesc");
        $this->field_list['estimateTime'] = $this->load->field('Field_timeslot',"预计时长(小时)","estimateTime");
        $this->field_list['estimateMoney'] = $this->load->field('Field_float',"预估金额","estimateMoney");

        $this->field_list['time_desc'] = $this->load->field('Field_string',"时间说明","time_desc");
        $this->field_list['time_desc']->tips = "界面上显示的是这个字段，纯文字描述";

        $this->field_list['beginTS'] = $this->load->field('Field_date',"开始日期","beginTS");
        $this->field_list['endTS'] = $this->load->field('Field_date',"结束日期","endTS");



        $this->field_list['yuyuefuwu'] = $this->load->field('Field_text',"服务内容模板","yuyuefuwu");

        $this->field_list['totalPrice'] = $this->load->field('Field_money',"总金额(￥)","totalPrice");

        $this->field_list['createUid'] = $this->load->field('Field_adminuserid',"创建人","createUid");
        $this->field_list['createTS'] = $this->load->field('Field_ts',"创建时间","createTS");
        $this->field_list['lastModifyUid'] = $this->load->field('Field_adminuserid',"最终编辑人","lastModifyUid");
        $this->field_list['lastModifyTS'] = $this->load->field('Field_ts',"最终编辑时间","lastModifyTS");
    }

    public function buildChangeShowFields(){
            return array(
                    array('name','orgId'),
                    array('status'),

                    array('limit_desc'),
                    array('limit_chepinpai'),
                    array('limit_typ'),
                    array('limit_size','limit_counter'),

                    array('time_desc'),
                    array('beginTS','endTS'),

                    array('typ'),
                    array('bookdesc'),
                    array('yuyuefuwu'),
                    array('estimateTime','totalPrice'),

                );
    }

    public function buildDetailShowFields(){
            return array(
                    array('name','orgId'),
                    array('status'),

                    array('limit_desc'),
                    array('limit_chepinpai'),
                    array('limit_typ'),
                    array('limit_size','limit_counter'),

                    array('time_desc'),
                    array('beginTS','endTS'),

                    array('typ'),
                    array('bookdesc'),
                    array('yuyuefuwu'),
                    array('estimateTime','totalPrice'),

                );
    }

    public function check_input($car_info,$packageId,$orgId){
        if (!$this->is_inited){
            $this->init_with_id($packageId);
        }

        if ($this->field_list['status']->value==2){
            return -1;
        }
        if ($this->field_list['limit_typ']->value==10){
            //共 X 个
            if ($this->field_list['limit_counter']->value<=0){
                return -2;
            }
        }
        $zeit = time();
        if ($zeit<$this->field_list['beginTS']->value){
            return -3;
        }
        if ($zeit>$this->field_list['endTS']->value+86400){
            return -4;
        }
        $limit_chepinpai = $this->field_list['limit_chepinpai']->value;
        $pinpai = $car_info->field_list['chexingbianhao']->value['pinpai'];
        if (count($limit_chepinpai)>0 && !in_array($pinpai['_id'],$limit_chepinpai)){
            return -5;
        }
        return 1;
    }

    public function gen_book($car_info,$packageId,$orgId){
        if (!$this->is_inited){
            $this->init_with_id($packageId);
        }

        $data = array();

        $data['orgId'] = $orgId;
        $data['typ'] = $this->field_list['typ']->value;
        $data['bookdesc']= $this->field_list['bookdesc']->value;
        $data['estimateTime']= $this->field_list['estimateTime']->value;
        $data['estimateMoney']= $this->field_list['totalPrice']->value;
        $data['totalPrice']= $this->field_list['totalPrice']->value;
        $data['active_id'] = $packageId;
        $data['active_name'] = $this->field_list['name']->value;
        $data['is_active'] = 1;


        $yuyuefuwu = json_decode($this->field_list['yuyuefuwu']->value,true);

        $yuyuefuwu['_id'] = new MongoId();
        foreach ($yuyuefuwu['peijians'] as $key => $value) {
            $yuyuefuwu['peijians'][$key]['_id'] = new MongoId();
        }
        $data['yuyuefuwu'][] = $yuyuefuwu;
        return $data;

    }

    public function reduce_count(){
        if ($this->field_list['limit_typ']->value==10){
            //共 X 个
            if ($this->field_list['limit_counter']->value>0){
                $data = array('limit_counter'=>$this->field_list['limit_counter']->value-1);
                $this->update_db($data);
            }
        }
    }
}
?>
