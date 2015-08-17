<form class="form-horizontal" role="form">
  <div class="form-group">
    <div class="row">
    <div class="col-lg-12">
        <table class="table">
                <tr>
                    <td class="td_title"><?php echo $this->dataInfo->field_list['name']->gen_editor_show_name(); ?></td>
                    <td colspan="3"><?php echo $this->dataInfo->field_list['name']->gen_editor($this->editor_typ) ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->dataInfo->field_list['desc']->gen_editor_show_name(); ?></td>
                    <td colspan="3"><?php echo $this->dataInfo->field_list['desc']->gen_editor($this->editor_typ) ?></td>
                    
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->dataInfo->field_list['relateTyp']->gen_editor_show_name(); ?></td>
                    <td class="td_data"><?php echo $this->dataInfo->field_list['relateTyp']->gen_hidden_editor($this->editor_typ,$this->dataInfo->field_list['relateTyp']->value) ?><?php echo $this->dataInfo->field_list['relateTyp']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->dataInfo->field_list['relateID']->gen_editor_show_name(); ?></td>
                    <td ><?php echo $this->dataInfo->field_list['relateID']->gen_hidden_editor($this->editor_typ,$this->dataInfo->field_list['relateID']->value) ?><?php echo $this->dataInfo->field_list['relateID']->gen_show_html() ?></td>
                    
                </tr>
                <tr>
                    <td><span class="field_name_must">上传文件 <em>*<em> </em></em></span></td>
                    <td colspan="3">
                    <label for="fileToUpload">选择文件</label>
                    <input id="fileToUpload" type="file" size="45" name="fileToUpload" class="input">

                    <p class=" text-danger help-block">请务必等待文档上传后再保存</p>
                    <button class="btn btn-primary" id="buttonUpload" onclick="return ajaxFileUpload('<?php echo site_url("document/doUpload")?>','<?=$this->dataInfo->field_list['fileLink']->build_input_name($this->editor_typ);?>');">上传</button>
                    <img id="loading" src="<?php echo static_url('misc/images/loading.gif'); ?>" style="display:none;">
                    <div id="upload_info" class="help-block">
                        <?php echo $this->dataInfo->field_list['fileLink']->gen_show_html() ?>
                    </div>
                    <?php echo $this->dataInfo->field_list['fileLink']->gen_hidden_editor($this->editor_typ,$this->dataInfo->field_list['fileLink']->value) ?>
                    </td>
                </tr>
        </table>
    </div>
    <div class="clearfix"></div>
</div>
</div>
</form>