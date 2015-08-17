<?php
if ($this->hasSearch){
    include_once(APPPATH."views/common/bread_and_search.php"); 
} else {
    include_once(APPPATH."views/common/bread.php");
}

?>
<?
if ($this->need_plus!=""){
    include_once(APPPATH."views/".$this->need_plus.".php");
}
?>
<div class="row">
    <?php
    if ($this->canEdit):
    ?>
    <div class="col-lg-12 list-title-op">
        <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="lightbox({size:'m',url:'<?=site_url($this->create_link)?>'})"><span class="glyphicon glyphicon-file"></span> 新建</a>
        
    </div>
    <?
    endif;
    ?>
    <?php
    if (isset($this->searchInfo) && $this->searchInfo['t']=="quick"):
    ?>
    <div class="col-lg-12 search_tips">
        <span class="glyphicon glyphicon-search"></span> 快捷搜索 : <?=(isset($this->quickSearchName)?$this->quickSearchName:'名称/编号');?> 包含 <?=(isset($this->quickSearchValue)?$this->quickSearchValue:'');?>;
        <a href='<?=site_url($this->controller_name.'/'.$this->method_name)?>'><span class='glyphicon glyphicon-circle-arrow-right'></span> 返回<?=$this->Menus->show_menus[$this->controller_name]['menu_array'][$this->method_name]['name']?></a>
    </div>
    <?php
    endif;
    if (isset($this->searchInfo) && $this->searchInfo['t']=="full"):
    ?>
    <div class="col-lg-12 search_tips">
        <span class="glyphicon glyphicon-search"></span> 高级搜索 :
        <?php
        foreach ($this->searchInfo['i'] as $key => $value) {
            echo  $this->listInfo->dataModel[$key]->gen_show_name();
            echo " : ";
            echo $this->listInfo->dataModel[$key]->gen_search_result_show($value['v']);
            echo " ; ";
        };
        ?>
        <a href='<?=site_url($this->controller_name.'/'.$this->method_name)?>'><span class='glyphicon glyphicon-circle-arrow-right'></span> 返回<?=$this->Menus->show_menus[$this->controller_name]['menu_array'][$this->method_name]['name']?></a>
    </div>
    <?php
    endif;
    ?>
    <div class="col-lg-12">
        <table class="table table-striped">
            <thead>
                <tr>
                    <?
                    foreach ($this->listInfo->build_list_titles() as $key_names):
                    ?>
                        <th>
                            <?php
                            echo $this->listInfo->dataModel[$key_names]->gen_show_name();;
                            ?>
                        </th>
                    <?
                    endforeach;
                    ?>
                    <?
                    foreach ($this->allOrgList->record_list as $key => $value) {
                    ?>
                        <th colspan="2"><?=$value->field_list['name']->value?></th>
                    <?
                    }
                    ?>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 0;

                foreach($this->listInfo->record_list as  $this_record): 
                    $i++;
                    ?>
                    <tr>
                        
                        <?
                        foreach ($this->listInfo->build_list_titles() as $key_names):
                        ?>
                            <td>
                                <?php
                                if ($this_record->field_list[$key_names]->is_title):
                                    if ($this->listInfo->is_lightbox):
                                        echo '<a href="javascript:void(0)" onclick="lightbox({size:\'m\',url:\''. site_url($this_record->info_link.$this_record->id).'\'})">'.$this_record->field_list[$key_names]->gen_list_html().'</a>';
                                    else :
                                        echo '<a href="'.site_url($this_record->info_link.$this_record->id).'">'.$this_record->field_list[$key_names]->gen_list_html().'</a>';
                                    endif;
                                else :
                                    echo $this_record->field_list[$key_names]->gen_list_html();

                                endif;
                                ?>
                            </td>
                        <?
                        endforeach;
                        ?>
                        <?
                        foreach ($this->allOrgList->record_list as $key => $value) {
                        ?>
                            <td><?=$this_record->field_list['counter_instore']->real_data[$key]?></td>
                            <td>￥<?=$this_record->field_list['chengben_instore']->real_data[$key]?></td>
                        <?
                        }
                        ?>
                        <td>
                            <?
                            if ($this->listInfo->is_lightbox):
                                echo '<a class="list_op tooltips" href="javascript:void(0)" onclick="lightbox({size:\'m\',url:\''. site_url($this_record->info_link.$this_record->id).'\'})"><span class="glyphicon glyphicon-search"></span></a>';
                            else :
                                echo '<a  class="list_op tooltips" href="'.site_url($this_record->info_link.$this_record->id).'"><span class="glyphicon glyphicon-search"></span></a>';
                            endif;
                            ?>
                             |
                            <?php
                            if ($this->canEdit) {
                                echo $this_record->gen_list_op();
                            }
                            ?>
                        </td>
                    </tr>
                <?php
                endforeach; ?>

            </tbody>
        </table>

        <nav class="center-block">
            <?php echo $this->pagination->create_links(); ?>
        </nav>
        <?php
        if (count($this->listInfo->record_list)==0):
        ?>
            <div class="no-data-large">
                没有相关记录
            </div>
        <?
        endif;
        ?>
    </div>
</div>
<script>


</script>
