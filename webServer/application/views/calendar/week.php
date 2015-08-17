<div>
    <ol class="breadcrumb">
        <li><a href="<?=site_url()?>"><span class='glyphicon glyphicon-home'></span> Home</a></li>
        <li><a href="<?=site_url($this->controller_name.'/week')?>"><span class='glyphicon <?=$this->menus[$this->controller_name]['icon']?>'></span> <?=$this->menus[$this->controller_name]['name']?></a></li>
        <li class="active"><span class='glyphicon glyphicon-file'></span> <?=$this->currentWeekModel->field_list['name']->gen_show_value() ?></li>
    </ol>
</div>
<div class="row">
    <div class="col-lg-12">
        <ul id="nav-week" class="nav nav-tabs">
            <?php
            foreach ($this->sub_menus as $key => $value) :
            ?>
                <li id="nav-week-<?php echo $key ?>" class="<?=($this->now_sub_menu==$key)?'active':'';?>"><a href="#" onclick="info_load('week','<?php echo $key ?>')"><?php echo $value['name'] ?></a></li>
            <?php
            endforeach;
            ?>
        </ul>
    </div>
</div>
<div id="week_info">
<?php
foreach ($this->sub_menus as $key => $value) :
    $is_hidden = ($this->now_sub_menu==$key)?'':'hidden';
    echo '<div class="info-week row '.$is_hidden.'" id="info-week-'.$key.'"><div class="col-md-12">';
    include_once("info-week-".$key.".php");
    echo '</div></div>';
endforeach;
?>
</div>
