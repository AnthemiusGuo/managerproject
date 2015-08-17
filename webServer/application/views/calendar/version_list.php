<ul class="nav nav-tabs">
    <li role="presentation" class="<?=($this->versionId=="")?'active':''?>">
        <a href="<?=site_url($this->controller_name.'/'.$this->method_name.'/')?>">全部</a>
    </li>
    <?
    foreach ($this->versionList->record_list as $this_record) {
    ?>
    <li role="presentation" class="<?=($this->versionId==$this_record->id)?'active':''?>">
        <a href="<?=site_url($this->controller_name.'/'.$this->method_name.'/'.$this_record->id)?>"><?=$this_record->name?>
        <small><?=$this_record->field_list['endTS']->gen_show_html()?></small></a>
    </li>
    <?
    }
    ?>
</ul>
