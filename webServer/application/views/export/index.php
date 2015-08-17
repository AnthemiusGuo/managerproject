<?
include_once(APPPATH."views/common/bread.php");
?>
<div class="row">
    <div class="col-lg-12 list-title-op ">
        <h3>按日按门店类</h3>
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
            <button class="btn btn-primary  btn-sm" type="button" onclick="search_order()">使用</button>
            <button class="btn btn-warning  btn-sm" type="button" onclick="reset_order()">重置</button>
          </span>
        </div>
        <div class="">
            注意，请先选择时间并点击 使用 后，再导出报表
        </div>
        <script type="text/javascript">
            $(function(){
              $("#filter_beginTS").datetimepicker({"autoclose": true,"language": "zh-CN","calendarMouseScroll": false,"dateOnly":true,format: 'yyyy-mm-dd',startView:'year',minView:'month'});
              $("#filter_endTS").datetimepicker({"autoclose": true,"language": "zh-CN","calendarMouseScroll": false,"dateOnly":true,'format' : 'yyyy-mm-dd',startView:'year',minView:'month'});
            });
            function search_order(){
              var url = req_url_template.str_supplant({ctrller:'aexport',action:'index'});
              url= url+'/'+$("#filter_orgId").val()+'/'+$("#filter_beginTS").val()+'/'+$("#filter_endTS").val();
              window.location.href=url;
            }
            function reset_order(){
              var url = req_url_template.str_supplant({ctrller:'aexport',action:'index'});
              window.location.href=url;
            }
        </script>
    </div>
  <div class="col-lg-12 list-title-op">
    <a href="<?=site_url('aexport/share_orders_finish/'.$this->store.'/'.$this->from.'/'.$this->to)?>" target="_blank" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share-alt"></span> 已完成订单导出</a>
    <a href="<?=site_url('aexport/share_orders_nopay/'.$this->store.'/'.$this->from.'/'.$this->to)?>" target="_blank" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share-alt"></span> 未付款订单导出</a>
    <a href="<?=site_url('aexport/share_orders_jishi/'.$this->store.'/'.$this->from.'/'.$this->to)?>" target="_blank" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share-alt"></span> 按技师订单导出</a>
  </div>
  <div class="col-lg-12 list-title-op">
      <a href="<?=site_url('aexport/export_peijian_use/'.$this->store.'/'.$this->from.'/'.$this->to)?>" target="_blank" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share-alt"></span> 配件消耗导出</a>
      <a href="<?=site_url('aexport/export_peijian_ruku/'.$this->store.'/'.$this->from.'/'.$this->to)?>" target="_blank" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share-alt"></span> 配件入库导出</a>
  </div>
</div>
<hr/>
<div class="row">
    <div class="col-lg-12 list-title-op">
        <h3>全部门店类</h3>

        <a href="<?=site_url('aexport/share_peijian')?>" target="_blank" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share-alt"></span> 配件详情导出</a>
		<a href="javascript:void(0)" class="btn btn-info btn-sm upload_holder"><span class="glyphicon glyphicon-paperclip"></span> 配件详情导入
		<input type="file" id="input_peijian_xiangqing" name="input_peijian_xiangqing">
            <script>
                setAjaxUpload({
                    fileDom:"#input_peijian_xiangqing",
                    url:'<?=site_url('aexport/uploads/xiangqing')?>',
                    successCallback:function(e,data){
                        json = data.result;
                        console.log(json);
                        lightbox({size:'m',url:'<?=site_url('aexport/imports/xiangqing/')?>'+'/'+json.data.link});
                    }
                });
            </script>
       	</a>
		<a href="<?=site_url('aexport/store_peijian')?>" target="_blank" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share-alt"></span> 配件清点导出</a>
		<a href="javascript:void(0)" class="btn btn-info btn-sm upload_holder">
            <span class="glyphicon glyphicon-paperclip"></span> 配件清点导入
        <input type="file" id="input_peijian_qingdian" name="input_peijian_qingdian">
            <script>
                setAjaxUpload({
                    fileDom:"#input_peijian_qingdian",
                    url:'<?=site_url('aexport/uploads/qingdian')?>',
                    successCallback:function(e,data){
                        json = data.result;
                        console.log(json);
                        lightbox({size:'m',url:'<?=site_url('aexport/imports/qingdian/')?>'+'/'+json.data.link});
                    }
                });
            </script>
        </a>
    </div>
    <div class="col-lg-12">
        <a href="<?=site_url('aexport/share_service')?>" target="_blank" class="btn btn-success btn-sm"><span class="glyphicon glyphicon-share-alt"></span> 服务详情导出</a>
		<a href="javascript:void(0)" class="btn btn-info btn-sm upload_holder"><span class="glyphicon glyphicon-paperclip"></span> 服务详情导入
		<input type="file" id="input_service_xiangqing" name="input_service_xiangqing">
            <script>
                setAjaxUpload({
                    fileDom:"#input_service_xiangqing",
                    url:'<?=site_url('aexport/uploads/service')?>',
                    successCallback:function(e,data){
                        json = data.result;
                        console.log(json);
                        lightbox({size:'m',url:'<?=site_url('aexport/imports/service/')?>'+'/'+json.data.link});
                    }
                });
            </script>
       	</a>
    </div>
</div>
