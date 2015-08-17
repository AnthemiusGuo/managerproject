<?
$editorData = $this->arrayPiceditorData;
$inputName = $editorData->build_input_name($editorData->editor_typ);
$validates = $editorData->build_validator();
if ($editorData->editor_typ==1){
    $editorData->default = $editorData->value;
}
?>
<div class="row">
<? 
foreach ($editorData->default as $key => $value) {
?>
	<div class="col-md-3 text_center">
        <div class="box-camera" id="holder_pic_<?=$key?>">
            <div class="real_pic" id="real_pic_<?=$key?>">
                <?
                if ($value!=""){
                ?>
                <img src="<?=static_url('auploads/'.$value)?>"/>
                <?
                }
                ?>
            </div>
            <span class="fa fa-camera"></span>
            <input type="file" id="input_pic_<?=$key?>" name="input_pic" accept="image/*" capture="camera">
            <script>
                setAjaxUpload({
                    fileDom:"#input_pic_<?=$key?>",
                    url:'<?=$editorData->uploadUrl.'/'.$key?>',
                    successCallback:function(e,data){
                        json = data.result;
                        $("#real_pic_<?=$key?>").html('<img src="'+json.data.url+'"/>');
                    }
                });
            </script>
        </div>
        
    </div>
<?
}
?>
</div>