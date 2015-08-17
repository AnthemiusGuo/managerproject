<?php
include_once(APPPATH."models/record_model.php");
class Manualpics_model extends Record_model {
    public function __construct() {
        parent::__construct('');
        $this->field_list['_id'] = $this->load->field('Field_mongoid',"id","_id");

        $this->field_list['name'] = $this->load->field('Field_string',"名称","name",true);
        $this->field_list['pic'] = $this->load->field('Field_pic',"图片","pics");
    }
    public function update_db($data,$id,$bookId){
        $real_data = array();
        foreach ($data as $key => $value) {
            $real_data['qitapaizhao.$.'.$key]=$value;
        }
        $this->db->where(array('qitapaizhao._id'=>new MongoId($id)))
        ->update('bBook',$real_data);
    }
    
}