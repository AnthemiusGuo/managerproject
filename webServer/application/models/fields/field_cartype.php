<?php
include_once(APPPATH."models/fields/fields.php");

class Field_cartype extends Fields {

    public function __construct($show_name,$name,$is_must_input=false) {
        parent::__construct($show_name,$name,$is_must_input);
        $this->typ = "Field_cartype";
        $this->real_data = array("","","");
    }
    public function init($value){
        parent::init($value);
    }

    public function gen_value($value){
        $this->real_data = explode('-', $value);
        $this->final_data = array();
        foreach ($this->real_data as $key => $id) {
            if ($key==0){
                $tableName = 'sCarPinpai';
                $tag = 'pinpai';
            } elseif ($key==1){
                $tableName = 'sCarChexi';
                $tag = 'chexi';
            } else {
                $tableName = 'sCarNianKuan';
                $tag = 'niankuan';
            }
            $real_id = new MongoId($id);
            $this->db->where(array('_id' => $real_id));
            $query = $this->db->get($tableName);
            if ($query->num_rows() > 0)
            {
                $result = $query->row_array();
                $this->final_data[$tag] = array('_id'=>$id,'name'=>$result['name']);
            }
        }
        return $this->final_data;
    }

    public function gen_show_html(){
        if (count($this->value)==0){
            return "未知车款";
        }
        $_html = $this->value['pinpai']['name']." > ".$this->value['niankuan']['name'];
        return $_html;
    }
    public function gen_show_value(){
        if (count($this->value)==0){
            return "未知车款";
        }
        $_html = $this->value['pinpai']['_id']."-".$this->value['chexi']['_id']."-".$this->value['niankuan']['_id'];
        return $_html;
    }

    public function gen_editor($typ=0){
        $this->editor_typ = $typ;
        $this->CI->carTypeEditorData = $this;

        $editor = $this->CI->load->view('editor/cartype', '', true);
        return $editor;
    }
}
?>
