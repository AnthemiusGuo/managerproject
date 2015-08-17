<div class="col-lg-12 list-title-op ">
    <div class="input-group input-group-sm">
      <span class="input-group-addon">门店</span>
      <select id="filter_orgId" name="filter_orgId" class="form-control">
        <option value="all" <?=($this->store=='all')?'selected':''?> >所有</option>
      <?
        foreach ($this->allOrgList->record_list as $key => $value) {
      ?>
          <option value="<?=$value->id?>" <?=($this->store==$value->id)?'selected':''?> ><?=$value->field_list['name']->value?></option>
      <?
        }
      ?>
      </select>
      <span class="input-group-addon">从</span>
      <input id="filter_beginTS" type="text" class="form-control" placeholder="<?=$this->from?>" value="<?=$this->from?>">
      <span class="input-group-addon">到</span>
      <input id="filter_endTS" type="text" class="form-control" placeholder="<?=$this->to?>" value="<?=$this->to?>">
      <span class="input-group-btn">
        <button class="btn btn-primary  btn-sm" type="button" onclick="search_order()">查询</button>
        <button class="btn btn-warning  btn-sm" type="button" onclick="reset_order()">重置</button>
      </span>
    </div>
    <script type="text/javascript">
        $(function(){
          $("#filter_beginTS").datetimepicker({"autoclose": true,"language": "zh-CN","calendarMouseScroll": false,"dateOnly":true,format: 'yyyy-mm-dd',startView:'year',minView:'month'});
          $("#filter_endTS").datetimepicker({"autoclose": true,"language": "zh-CN","calendarMouseScroll": false,"dateOnly":true,'format' : 'yyyy-mm-dd',startView:'year',minView:'month'});
        });
        function search_peijianflow(){
          var url = req_url_template.str_supplant({ctrller:'amanagement',action:'peijianflow'});
          url= url+'/'+$("#filter_orgId").val()+'/'+$("#filter_beginTS").val()+'/'+$("#filter_endTS").val();
          window.location.href=url;
        }
        function reset_peijianflow(){
          var url = req_url_template.str_supplant({ctrller:'amanagement',action:'peijianflow'});
          window.location.href=url;
        }
    </script>
</div>