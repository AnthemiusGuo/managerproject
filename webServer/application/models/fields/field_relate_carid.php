<?php
include_once(APPPATH."models/fields/field_relate_simple_id.php");
class Field_relate_carid extends Field_relate_simple_id {
    public $where = array();

    public function __construct($show_name,$name,$is_must_input=false) {
        parent::__construct($show_name,$name,$is_must_input);
        $this->set_relate_db('uUser','cars._id','cars.$');
        $this->needOrgId = 0;
        $this->xinghao = '';
        $this->chepaihao = '';
        
    }
    public function init($value){
        parent::init($value);
        
        if ($value===0||$value==="0" || $value==="" || $value===null){
            $this->showValue = ' - ';

            return;
        }
        $this->valueSetted = true;

        if (!is_object($value) && $this->relate_id_is_id){
            $real_value = new MongoId($value);
        } else {
            $real_value = $value;
        }

        $this->db->select(array($this->valueField,$this->showField))
            ->where(array($this->valueField => $real_value))
            ->limit(1);
        $this->checkWhere();

        $query = $this->db->get($this->tableName);
        if ($query->num_rows() > 0)
        {
            $result = $query->row_array();
            $this->carArray = $result['cars'][0];
            // $this->xinghao = $result['cars'][0]['chexingbianhao']['pinpai']['name'].' > '.
            		// $result['cars'][0]['chexingbianhao']['niankuan']['name'];
            $this->xinghao = $result['cars'][0]['chexingbianhao']['niankuan']['name'];
            $this->chepaihao = $result['cars'][0]['chepaihao'];

            $this->showValue = $this->xinghao.' '.$this->chepaihao;
            $this->value_checked = 1;
        } else {
        	$this->xinghao = '其他品牌';
        	$this->chepaihao = '未知车牌';
            $this->showValue = '[未知车辆(id:'.$value.')]';
            $this->value_checked = -1;
        }
    }

    public function setEnum($crmId){
        $this->db->where(array('_id'=>new MongoId($crmId)));
        $query = $this->db->get($this->tableName);

        $this->enum[0] = ' - ';
        if ($query->num_rows() > 0)
        {
            foreach ($query->result_array() as $row)
            {
                foreach ($row['cars'] as $key => $value) {
                    $this->enum["".$value['_id']] = $value['chepaihao'];
                }
                
            }

        }

    } 

}
?>
