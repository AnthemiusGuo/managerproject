<?php include_once('perInfoHead.php')?>
<div class="info-perInfo row" id="info-perInfo-mini_info">
    <div class="col-lg-12">
        <table class="table">
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['name']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['name']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->userInfo->field_list['sex']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['sex']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['nickname']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['nickname']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->userInfo->field_list['usenick']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['usenick']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['email']->gen_show_name(); ?></td>
                    <td colspan="3"><?php echo $this->userInfo->field_list['email']->gen_show_html() ?></td>
                    
                </tr>
                
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['regTS']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['regTS']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->userInfo->field_list['beginNGOTS']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['beginNGOTS']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['birthTS']->gen_show_name(); ?></td>
                    <td colspan="3"><?php echo $this->userInfo->field_list['birthTS']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['idType']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['idType']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->userInfo->field_list['idNumber']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['idNumber']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['nationId']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['nationId']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->userInfo->field_list['provinceId']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['provinceId']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['addresses']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['addresses']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->userInfo->field_list['zipCode']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['zipCode']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['phoneNumber']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['phoneNumber']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->userInfo->field_list['qqNumber']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['qqNumber']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['wechatNumber']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['wechatNumber']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->userInfo->field_list['weiboNumber']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['weiboNumber']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['otherContact']->gen_show_name(); ?></td>
                    <td colspan="3"><?php echo $this->userInfo->field_list['otherContact']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['education']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['education']->gen_show_html() ?></td>
                    <td class="td_title"><?php echo $this->userInfo->field_list['school']->gen_show_name(); ?></td>
                    <td><?php echo $this->userInfo->field_list['school']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['major']->gen_show_name(); ?></td>
                    <td colspan="3"><?php echo $this->userInfo->field_list['major']->gen_show_html() ?></td>
                </tr>
                <tr>
                    <td class="td_title"><?php echo $this->userInfo->field_list['outcomming']->gen_show_name(); ?></td>
                    <td colspan="3"><?php echo $this->userInfo->field_list['outcomming']->gen_show_html() ?></td>
                    
                </tr>
                

        </table>
    </div>
    <div class="clearfix"></div>
</div>
<?php include_once('perInfoFoot.php')?>