<div class="row">
    <div class="col-lg-12">
        <table class="table table-striped">
            <?php
            foreach ($this->showNeedFields as $key => $value) {
            ?>
            <tr>
                <?php
                $colspan = 0;
                if (count($value)==1){
                    $colspan = 3;
                }
                foreach ($value as $k => $v) {
                    if ($v=="null") {
                ?>
                    <td class="td_title"></td><td class="td_data"></td>
                <?
                    } else {
                ?>
                    <td class="td_title"><?php echo $this->dataInfo->field_list[$v]->gen_show_name(); ?></td>
                    <td <?=($colspan==0)?'class="td_data"':'colspan="'.$colspan.'"'?> >
                            <?php echo $this->dataInfo->field_list[$v]->gen_show_html() ?>
                    </td>
                <?
                    }
                ?>

                <?
                }
                ?>
            </tr>
            <?
            }
            ?>
        </table>
    </div>
    <div class="clearfix"></div>
    <div class="col-lg-12">
    图片上传
    <?=$this->dataInfo->field_list['pic']->gen_editor(1)?>
    </div>
</div>
