<?php
include_once(APPPATH."models/fields/field_array.php");
class Field_array_pics extends Field_array {

    public function __construct($show_name,$name,$is_must_input=false) {
        parent::__construct($show_name,$name,$is_must_input);
        $this->typ = "Field_array";
        $this->value = array();
        $this->imgCountLimit = 0;
        $this->uploadUrl = "amanagement/upload";
    }
    public function setimgCountLimit($count){
        $this->imgCountLimit = $count;
        for ($i=0;$i<$count;$i++) {
            $this->value[] = "";
        }
    }
    public function init($value){
        if (gettype($value)!=="array"){
            for ($i=0;$i<$this->imgCountLimit;$i++) {
                $value[] = "";
            }
        } else {
            for ($i=0;$i<$this->imgCountLimit;$i++) {
                if (!isset($value[$i])){
                    $value[] = "";
                }

            }
        }


        $this->value = $value;
    }
    public function gen_list_html($limit = 0){
        $_html = '';

        return $_html;
    }
    public function gen_show_html(){
        $_html = '<ul class="list-group">';

        $_html .= "</ul>";
        return $_html;
    }
    public function gen_value($input){
        if (gettype($input)!=="array"){
            for ($i=0;$i<$this->imgCountLimit;$i++) {
                $input[] = "";
            }
        }
        return $input;
    }
    

    public function gen_front_common_editor($typ=0,$uploadHandler=''){
        $this->editor_typ = $typ;
        $this->uploadHandler = $uploadHandler;
        $this->CI->arrayPiceditorData = $this;
        $editor = $this->CI->load->view('editor/array_pic_front', '', true);
        return $editor;
    }
    public function gen_editor($typ=0){
        // $this->editor_url
        // $inputName = $this->build_input_name($typ);
        // $validates = $this->build_validator();
        // if ($typ==1){
        //     $this->default = $this->value;
        // }
        // return "<input id=\"{$inputName}\" name=\"{$inputName}\" class=\"{$this->input_class}\" placeholder=\"{$this->placeholder}\" type=\"text\" value=\"{$this->default}\" $validates /> ";
        $this->editor_typ = $typ;
        $this->CI->arrayPiceditorData = $this;
        $editor = $this->CI->load->view('editor/array_pic', '', true);
        return $editor;
    }
    public function check_data_input($input)
    {
        if ($input==0){
            return false;
        }
        if (is_array($input) && count($input)==0){
            return false;
        }
        return parent::check_data_input($input);
    }
}
?>
