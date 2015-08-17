<ul class="nav nav-tabs">
    <li role="presentation" class="<?=($this->weekId=="")?'active':''?>">
        <a href="<?=site_url($this->controller_name.'/'.$this->method_name.'/')?>">全部</a>
    </li>
    <?
    foreach ($this->weekList->record_list as $this_record) {
    ?>
    <li role="presentation" class="<?=($this->weekId==$this_record->id)?'active':''?>">
        <a href="<?=site_url($this->controller_name.'/'.$this->method_name.'/'.$this_record->id)?>"><?=$this_record->name?></a>
    </li>
    <?
    }
    ?>
</ul>
