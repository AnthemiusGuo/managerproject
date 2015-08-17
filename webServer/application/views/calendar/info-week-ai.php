<div class="col-lg-12">
    <table class="table table-striped">
        <thead>
            <tr>
                <?
                foreach ($this->aiList->listKeys as $key_names):
                ?>
                    <th>
                        <?php
                        echo $this->aiList->dataModel[$key_names]->gen_show_name();;
                        ?>
                    </th>
                <?
                endforeach;
                ?>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;

            foreach($this->aiList->record_list as  $this_record):
                $i++;
                ?>
                <tr>

                    <?
                    foreach ($this->aiList->listKeys as $key_names):
                    ?>
                        <td>
                            <?php
                            if ($this_record->field_list[$key_names]->is_title):
                                if ($this->aiList->is_lightbox):
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
                    <td>
                        <?
                        if ($this->aiList->is_lightbox):
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
    <?php
    if (count($this->aiList->record_list)==0):
    ?>
        <div class="no-data-large">
            没有相关记录
        </div>
    <?
    endif;
    ?>

</div>
