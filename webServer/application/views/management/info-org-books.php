<div>
    <table class="table table-striped simplePagerContainer">
        <thead>
            <tr>
                <?
                foreach ($this->bookList->build_inline_list_titles() as $key_names):
                ?>
                    <th>
                        <?php
                        echo $this->bookList->dataModel[$key_names]->gen_show_name();;
                        ?>
                    </th>
                <?
                endforeach;
                ?>
                <th>操作</th>
            </tr>
        </thead>
        <tbody class="crm-book-table-paged" id="crm-book-table">
            <?php
            $i = 1;

            foreach($this->bookList->record_list as  $this_record): ?>
                <tr>
                    <?
                    foreach ($this->bookList->build_inline_list_titles() as $key_names):
                    ?>
                        <td>
                            <?php
                            if ($this_record->field_list[$key_names]->is_title):

                                echo '<a href="javascript:void(0)" onclick="lightbox({url:\''. site_url($this_record->info_link.$this_record->id).'\'})">'.$this_record->field_list[$key_names]->gen_list_html().'</a>';
                            elseif ($this_record->field_list[$key_names]->typ=="Field_text"):
                                echo $this_record->field_list[$key_names]->gen_list_html(8);
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
                        if ($this->bookList->is_lightbox):
                            echo '<a class="list_op tooltips" href="javascript:void(0)" onclick="lightbox({size:\'m\',url:\''. site_url($this_record->info_link.$this_record->id).'\'})"><span class="glyphicon glyphicon-search"></span></a>';
                        else :
                            echo '<a  class="list_op tooltips" href="'.site_url($this_record->info_link.$this_record->id).'"><span class="glyphicon glyphicon-search"></span></a>';
                        endif;
                        ?>
                         |
                        <?php echo $this_record->gen_list_op()?>
                    </td>
                </tr>
            <?php $i++;
            endforeach; ?>

        </tbody>
    </table>
    <?
    if (count($this->bookList->record_list)<=0){
    ?>
    <div class="no-data-large">
        没有相关记录
    </div>
    <?
    }
    ?>
    <div id="crm-book-list_pager">

    </div>
</div>
