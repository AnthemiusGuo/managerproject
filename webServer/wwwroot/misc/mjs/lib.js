if (!String.prototype.str_supplant) {
    String.prototype.str_supplant = function (o) {
        return this.replace(/{([^{}]*)}/g,
            function (a, b) {
                var r = o[b];
                return typeof r === 'string' || typeof r === 'number' ? r : a;
            }
        );
    };
}

if (!String.prototype.trim) {
    String.prototype.trim = function () {
        return this.replace(/^\s*(\S*(?:\s+\S+)*)\s*$/, "$1");
    };
}
(function($) {
  $.uuid = function() {
        return 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random()*16|0, v = c == 'x' ? r : (r&0x3|0x8);
            return v.toString(16);
        });
    };
})(jQuery);

function myParseFloat(input){
    var ret = parseFloat(input);
    console.log(ret);
    if (isNaN(ret)){
        return 0
    } else {
        return ret;
    }
}

function refresh(){
    window.location.href = window.location.href;
}
function gotoPage(m,a){
    window.location.href = req_url_template.str_supplant({ctrller:m,action:a});;
}
function gotoUrl(url){
    window.location.href = url;
}
function ajax_get(opts){
    var dft_opt = {
        m: 'index',
        a: 'index',
        id: '',
        data: {},
        popSuccess : 1,//0->不提示 1->提示
        popError : 1,//0->不提示 1->提示
        successCallback : null,
        errorCallback : null,
    };
    opts = $.extend({},dft_opt,opts);
    $.blockUI({ css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            'border-radius': '5px',
            opacity: .7,
            color: '#fff'
        },
        message:  '<h3>请稍候</h3>'  });
    var url = req_url_template.str_supplant({ctrller:opts.m,action:opts.a});
    url = url + '/'+opts.id;
    $.each(opts.data,function(k,v){
        url = url + '&'+k+'='+v;
    });
    $.ajax(
        {type: "GET",
        url: url,
        dataType:"json"}
    ).done(function(json) {
        $.unblockUI();
         if(json.rstno == 1)  {
            if (opts.popSuccess === 1){alertPlug.alert(json.data['err']['msg'],'s') };
            if (opts.successCallback != null) {opts.successCallback.apply( this,arguments)};
        } else {
           if (opts.popError === 1){ alertPlug.alert(json.data['err']['msg'],'e') };
           if (opts.errorCallback != null) {opts.errorCallback.apply( this,arguments)};
        }
    }).fail(function() {
       $.unblockUI();
       alert('网络故障，请稍候重试');
    }).always(function() {
        //$.unblockUI();
    });
}
function ajax_post(opts){
    var dft_opt = {
        m: 'index',
        a: 'index',
        url: null,
        plus: '',
        data: {},
        popSuccess : 1,//0->不提示 1->提示
        popError : 1,//0->不提示 1->提示
        autoBlock: 1,
        successCallback : null,
        errorCallback : null,
    };
    opts = $.extend({},dft_opt,opts);
    if (opts.autoBlock==1){
        $.blockUI({ css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            'border-radius': '5px',
            opacity: .7,
            color: '#fff'
        },
        message:  '<h3>请稍候</h3>' });
    }
    if (opts.url==null){
        var url = req_url_template.str_supplant({ctrller:opts.m,action:opts.a})+'/'+opts.plus;
    } else {
        var url = opts.url+'/'+opts.plus;
    }

    $.ajax(
        {type: "POST",
        url: url,
        dataType:"json",
        data: opts.data}
    ).done(function(json) {
        if (opts.autoBlock==1){
            $.unblockUI();
        }

        if(json.rstno >= 1)  {
            if (opts.popSuccess === 1){alertPlug.alert(json.data['err']['msg'],'s') };
            if (opts.successCallback != null) {opts.successCallback.apply( this,arguments)};
        } else {
           if (opts.popError === 1){ alertPlug.alert(json.data['err']['msg'],'e') };
           if (opts.errorCallback != null) {opts.errorCallback.apply( this,arguments)};
        }
    }).fail(function() {
        if (opts.autoBlock==1){
            $.unblockUI();
        }
        alert('网络故障，请稍候重试');
    }).always(function() {
        //$.unblockUI();
    });
}

function ajax_load(selector,url) {
    $(selector).load(url);
}

function page_load(opts){
	var dft_opt = {
        m: 'index',
        a: 'index',
        plus: '',
        data: {},
        typ: 'overlay',
        callback: null,
        failCallback:null
    };
    opts = $.extend({},dft_opt,opts);
    if (opts.typ=='overlay'){
        // $("#main_nav").addClass('hide');
    	$("#total-page").addClass("hide");
    	$("#overlay-page").removeClass("hide");
    } else if (opts.typ=='double_overlay'){
        // $("#main_nav").addClass('hide');

        $("#overlay-page").addClass("hide");
        $("#double-overlay-page").removeClass("hide");
    }
    $.blockUI({ css: {
            border: 'none',
            padding: '15px',
            backgroundColor: '#000',
            'border-radius': '5px',
            opacity: .7,
            color: '#fff'
        },
        message:  '<h3>请稍候</h3>' });
    var url = req_url_template.str_supplant({ctrller:opts.m,action:opts.a})+'/'+opts.plus;
    $.ajax(
        {type: "POST",
        url: url,
        dataType:"html",
        data: opts.data}
    ).done(function(html) {
        $.unblockUI();
    	if (opts.typ=='overlay') {
            $("#overlay-page").html(html);
        } else if (opts.typ=='double_overlay'){
            $("#double-overlay-page").html(html);
	    } else if (opts.typ=="replace"){
	    	$("#total-page").html(html);
	    }
        if (opts.callback != null){
            opts.callback.apply(this, arguments);
        }
    }).fail(function() {
        $.unblockUI();
        closeOverlay();
        if (opts.failCallback != null){
            opts.failCallback.apply(this, arguments);
        }
	    alert('网络故障，请稍候重试');
    }).always(function() {
        //$.unblockUI();
    });
}

function closeOverlay(opts){
    var dft_opt = {
        callback: null
    };
    opts = $.extend({},dft_opt,opts);
    if ($("#overlay-page").hasClass('hide')){
        $("#double-overlay-page").html('').addClass("hide");
        $("#overlay-page").removeClass("hide");

    } else {
        $("#total-page").removeClass("hide");
        $("#main_nav").removeClass('hide');

        $("#overlay-page").html('').addClass("hide");
    }
}


function lightbox(opts) {
    var default_opts = {
        size:'m',
        url:''
    };

    var width = 720;
    if (opts.size=="l"){
        width = 960;
    } else if (opts.size=="s"){
        width=600;
    }
    opts = $.extend(default_opts,opts);
    $.fancybox.open({href : opts.url,type:'ajax',autoSize:false,autoHeight:false,autoWidth:false,width:width,height:500});
    return;
    if ($("#lightbox").data('bs.modal')){
        $("#lightbox").modal('hide').one('hidden.bs.modal', function (e) {
            $("#lightbox").removeClass("lightbox_l lightbox_m lightbox_s").addClass("lightbox_"+opts.size).modal({remote:opts.url}).on('hidden.bs.modal', function (e) {
                hide_relate_box();
                $(this).removeData('bs.modal');
            });
        });
    } else {
        $("#lightbox").removeClass("lightbox_l lightbox_m lightbox_s").addClass("lightbox_"+opts.size).modal({remote:opts.url}).on('hidden.bs.modal', function (e) {
            hide_relate_box();
            $(this).removeData('bs.modal');
        });
    }


}

function lightbox_close(){
    hide_relate_box();
    $("#lightbox").modal('hide').on('hidden.bs.modal', function (e) {
        $(this).removeData('bs.modal');

    });
    $(".modal-backdrop").remove();
}

function data_list_hover(dom_name){
    $('.'+dom_name).each(function(){
        $(this).click(function(){
            $('.'+dom_name).removeClass('hover');
            $(this).removeClass('hover');
        })
    })
}

var alertPlug = {
    modal : function(opts){
        var dft_opt = {
            m: 'index',
            a: 'index',
            id: '',
            data: {},
        };
        opts = $.extend({},dft_opt,opts);
        $.blockUI({ css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                'border-radius': '5px',
                opacity: .7,
                color: '#fff'
            },
            message:  '<h3>请稍候</h3>'  });
        var url = req_url_template.str_supplant({ctrller:opts.m,action:opts.a});
        url = url + '/'+opts.id;
        $.each(opts.data,function(k,v){
            url = url + '&'+k+'='+v;
        });
        $("#common_modal").html('').load(url,function(){
            $.unblockUI();
            $(this).modal('show').css({
                'top': function () { //vertical centering
                    return (($(this).height() - $('#common_modal .modal-dialog').height())/ 2);
                }
            });
        });
    },
    confirmCon : function(domId){
        // if (sub_system=='m'){
        //     $.blockUI({
        //         css: {
        //             border: 'none',
        //             background: 'none',
        //             left:'5%',
        //             width:'90%',
        //             top:'10%',
        //             fadeIn:0
        //         },
        //         message: $("#"+domId),
        //     });
        // } else {
            $("#"+domId).modal('show').css({
                'top': function () { //vertical centering
                    return (($(this).height() - $('#'+domId+' .modal-dialog').height())/ 2);
                }
            });
        // }
    },
    showPic : function(picHolderDom,imgDom){
        var imgWidth = $(imgDom).width();
        var imgHeight = $(imgDom).height();
        var realHeight = $(window).width()/imgWidth*imgHeight;

        $.blockUI({
            message: $(imgDom),
            css: {
                border: 'none',
                left: 0,
                top: ($(window).height() -realHeight)/2 + 'px',
                height:realHeight + 'px',
                width: '100%' ,
                fadeIn:0

            }
        });
        $(".blockUI "+imgDom).one('click',function(){
            $.unblockUI();
        })

    },
    alert: function(msg,type){

        var _bt_html = '';
        var title = '';
        var pop_title_style = '';
        if(type == 'c'){
            //confirm TODO
        }else if(type == 's'){
            //成功
            title = "成功了";
            pop_title_style = 'pop_title_blue';
            _bt_html = '<button type="button" onclick="alertPlug.close();" class="pure-button button-secondary button-xlarge">确　定</button>';
        } else {
            //error
            title = "出错了";
            pop_title_style = 'pop_title_red';
            _bt_html = '<button type="button" onclick="alertPlug.close();" class="pure-button button-secondary button-xlarge pop_button_red">确　定</button>';
        }
        // if (sub_system=='m'){
        //     var _html = '<div id="popAlertbox" class="hide">'+
        //                 '<div class="popBox">'+
        //                     '<div class="pop_title '+pop_title_style+'">'+title+'</div>'+
        //                     '<div class="popBoxInfo">'+
        //                         '<p class="pop_info">'+msg+'</p>'+
        //                         '<hr class="pop_hr"/>'+
        //                         '<div class="pop_control">'+_bt_html+'</div>'+
        //                     '</div>'+
        //                 '</div>'+
        //             '</div>';
        // } else {
            var _html = '<div class="modal" id="popAlertbox" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">'+
  '<div class="modal-dialog"><div class="modal-content"><div class="modal-header">'+
        '<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
        '<h4 class="modal-title" id="myModalLabel">{title}</h4>'+
      '</div><div class="modal-body">{msg}</div>'+
      '<div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">关闭</button></div>'+
    '</div></div></div>';
            _html = _html.str_supplant({pop_title_style:pop_title_style,title:title,msg:msg,_bt_html:_bt_html});
        // }

        $("#popAlertbox").remove();
        $('.page').append(_html);
        // if (sub_system=='m'){
        //     $.blockUI({
        //         css: {
        //             border: 'none',
        //             background: 'none',
        //             left:'5%',
        //             width:'90%',
        //             top:'30%',
        //             fadeIn:0

        //         },
        //         message: $("#popAlertbox"),
        //     });
        // } else {
            $('#popAlertbox').modal('show').css({
                'top': function () { //vertical centering
                    return (($(this).height() - $('#popAlertbox .modal-dialog').height())/ 2);
                }
            });
        // }
    },
    close:function(){
        $.unblockUI();
    }
}
/*返回上一页*/
function return_prepage()  {
    if(window.document.referrer==""||window.document.referrer==window.location.href)
    {
        window.location.href="{dede:type}[field:typelink /]{/dede:type}";
    }else  {
        window.location.href=window.document.referrer;
    }
}
//js 加减日期
Date.prototype.Format = function(fmt)
{
    var o =
     {
        "M+" : this.getMonth() + 1, //月份
        "d+" : this.getDate(), //日
        "h+" : this.getHours(), //小时
        "m+" : this.getMinutes(), //分
        "s+" : this.getSeconds(), //秒
        "q+" : Math.floor((this.getMonth() + 3) / 3), //季度
        "S" : this.getMilliseconds() //毫秒
     };
    if (/(y+)/.test(fmt))
         fmt = fmt.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
    for (var k in o)
        if (new RegExp("(" + k + ")").test(fmt))
             fmt = fmt.replace(RegExp.$1, (RegExp.$1.length == 1) ? (o[k]) : (("00" + o[k]).substr(("" + o[k]).length)));
    return fmt;
}

Date.prototype.addDays = function(d)
{
    this.setDate(this.getDate() + d);
};


Date.prototype.addWeeks = function(w)
{
    this.addDays(w * 7);
};


Date.prototype.addMonths= function(m)
{
    var d = this.getDate();
    this.setMonth(this.getMonth() + m);

    if (this.getDate() < d)
        this.setDate(0);
};


Date.prototype.addYears = function(y)
{
    var m = this.getMonth();
    this.setFullYear(this.getFullYear() + y);

    if (m < this.getMonth())
     {
        this.setDate(0);
     }
};

var timeContrl = {
    initTime:function(setDate){
        if (typeof(setDate)==="undefined"){
            var now  = new Date();
        } else {
            var a = setDate.split(/[^0-9]/);
//for (i=0;i<a.length;i++) { alert(a[i]); }
            var now=new Date (a[0],a[1]-1,a[2],a[3],a[4],a[5] );
            // var now  = new Date(setDate);
        }

        this.initFormatTime(now);
        var current_h_v = now.Format ("h");
        if (current_h_v<8) {
            current_h_v =8;
        }
        if (current_h_v>20) {
            current_h_v =20;
        }
        var current_h = this.formatHour(current_h_v);

        $('#yu_hour').val(current_h);
        $('#yu_hour').attr('current_h',current_h_v);
        //$("#bookTS").val(''); //初始无数据
        this.confirmTime();//初始化时当前可预约最近时间
    },
    initFormatTime:function(nowTime){
        var current_y = nowTime.Format ("yyyy");
        var current_m = nowTime.Format ("M");
        var current_d = nowTime.Format ("d");
        $('#yu_y').val(current_y);
        $('#yu_m').val(current_m);
        $('#yu_d').val(current_d);
    },
    //抓取new date()
     getNewDate:function(Time){
        var a = Time.split(/[^0-9]/);
//for (i=0;i<a.length;i++) { alert(a[i]); }
        var now=new Date (a[0],a[1]-1,a[2],0,0,0 );
            // var now  = new Date(setDate);
        return now;
     },
    addYear:function(type){
        var now  = this.getNewDate(""+$('#yu_y').val()+"-"+$('#yu_m').val()+"-"+$('#yu_d').val()+"");
        if(type == 1){
            var _num = 1;
        } else if(type == 2){
            var _num = -1;
        }
        now.addYears(_num);
        this.initFormatTime(now);
    },
    addMonth:function(type){
        var now  = this.getNewDate(""+$('#yu_y').val()+"-"+$('#yu_m').val()+"-"+$('#yu_d').val()+"");
        if(type == 1){
            var _num = 1;
        } else if(type == 2){
            var _num = -1;
        }
        now.addMonths(_num);
        this.initFormatTime(now);
        this.confirmTime();

    },
    addDay:function(type){
        var now  = this.getNewDate(""+$('#yu_y').val()+"-"+$('#yu_m').val()+"-"+$('#yu_d').val()+"");
        if(type == 1){
            var _num = 1;
        } else if(type == 2){
            var _num = -1;
        }
        now.addDays(_num);
        this.initFormatTime(now);
        this.confirmTime();

    },
    addHour:function(type){
        if(type == 1){
            var _num = parseInt($('#yu_hour').attr('current_h'))+1;
        } else if(type == 2){
            var _num = parseInt($('#yu_hour').attr('current_h'))-1;
        }
        if(_num >= 20){
            _num = 20;
        }else if(_num <= 8){
            _num = 8;
        }
        $('#yu_hour').attr('current_h',_num);
        $('#yu_hour').val(this.formatHour(_num));
        this.confirmTime();
    },
    formatHour:function(current_h){
        var h_fmt = '';
        if(current_h > 20){
            return h_fmt;
        } else if(current_h < 8){
            return h_fmt;
        } else {
            var _next_h = parseInt(current_h)+1;
            h_fmt = current_h+':30-'+_next_h+':30';
            return h_fmt;
        }
    },
    confirmTime:function(){
        var y = $('#yu_y').val();
        var m = $('#yu_m').val();
        var d = $('#yu_d').val();
        var h = $('#yu_hour').val();
        var bookTS = y + "-"+ m + "-" +d+" "+ h;
        $("#bookTS").val(bookTS);
        $("#bookTSLabel").html(bookTS);
    },
    clickWeek:function(indexNum){
        var book_ts = $('.quickTimeClick').eq(indexNum).attr('book_ts');
        var book_hour = $('.quickTimeClick').eq(indexNum).attr('book_hour');
        var hour_str = this.formatHour(book_hour);
        $('#yu_hour').attr('current_h',hour_str);
        $('#yu_hour').val(hour_str);

        this.initFormatTime(this.getNewDate(book_ts));
        this.confirmTime();

    }
};
var scoreControl = {
    initScore : function(){
        var _html = [];
        for(var i=0; i<5; i++){
            _html[i] = '<span class="font-fa-score fa fa-star-o" onclick="scoreControl.clickScore(this)"></span>';
        }
        var fmt = _html.join('');
        $('#score').html(fmt);
        $('#kh_score').html(fmt);
        $('#hj_score').html(fmt);
        $('#jishi_score').html(fmt);
    },
    clickScore:function(obj){
        var scoreId = $(obj).parent().attr('id');
        $('#'+scoreId+' span').removeClass('fa-star');
        $('#'+scoreId+' span').addClass('fa-star-o');
        var IndexNum = parseInt($(obj).index());
        var j = IndexNum+1;
        for(var i=0; i<j; i++){
            $('#'+scoreId+' span').eq(i).removeClass('fa-star-o');
            $('#'+scoreId+' span').eq(i).addClass('fa-star');
        }
        $("#"+scoreId+"_input").val(j);
    }
}

var dataURLToBlob = function(dataURL) {
    var BASE64_MARKER = ';base64,';
    if (dataURL.indexOf(BASE64_MARKER) == -1) {
        var parts = dataURL.split(',');
        var contentType = parts[0].split(':')[1];
        var raw = parts[1];

        return new Blob([raw], {type: contentType});
    }

    var parts = dataURL.split(BASE64_MARKER);
    var contentType = parts[0].split(':')[1];
    var raw = window.atob(parts[1]);
    var rawLength = raw.length;

    var uInt8Array = new Uint8Array(rawLength);

    for (var i = 0; i < rawLength; ++i) {
        uInt8Array[i] = raw.charCodeAt(i);
    }

    return new Blob([uInt8Array], {type: contentType});
}

function setAjaxUpload(opts){
    var default_opts = {
        fileDom:'',
        popError:1,
        url:req_url_template.str_supplant({ctrller:'uorder',action:'upload'}),
        successCallback:null,
        errorCallback:null
    };

    opts = $.extend(default_opts,opts);

    $(opts.fileDom).change(function () {
        // 也可以传入图片路径：lrz('../demo.jpg', ...
        lrz(this.files[0], {
            width: 800,
            quality:0.7

        },function (results) {
            // 你需要的数据都在这里，可以以字符串的形式传送base64给服务端转存为图片。
            //rst.base64 生成后的图片base64，后端可以处理此字符串为图片
            // rst.base64Len 生成后的图片的大小，后端可以通过此值来校验是否传输完整
            // rst.origin 也就是file对象，里面存了一些图片文件的信息，例如大小，日期等。
            console.log(results);
            ajax_post({
                url:opts.url,
                data: {img:results.base64},
                popSuccess : 0,
                successCallback : function(){
                    results.base64 = null;
                    if (opts.successCallback != null){
                        opts.successCallback.apply(this, arguments);
                    }
                },
                errorCallback : function(){
                    results.base64 = null;
                    if (opts.errorCallback != null){
                        opts.errorCallback.apply(this, arguments);
                    }
                },
            });

        });
    });

}

function setAjaxUploadOld(opts){
    var default_opts = {
        fileDom:'',
        popError:1,
        url:req_url_template.str_supplant({ctrller:'uorder',action:'upload'}),
        successCallback:null,
        errorCallback:null
    };

    opts = $.extend(default_opts,opts);

    $(opts.fileDom).fileupload({
        dataType: 'json',
        singleFileUploads: true,

        url: opts.url,
        done: function (e, data) {
            $.unblockUI();
            var json = data.result;
            if (json.rstno == 1) {

                if (opts.successCallback != null){
                    opts.successCallback.apply(this, arguments);
                }
            } else {
                if (opts.popError === 1){ alert(json.data['err']['msg']) };
                if (opts.errorCallback != null) {opts.errorCallback.apply( this,arguments)};
            }
            // $.each(data.result.files, function (index, file) {
            //     $('<p/>').text(file.name).appendTo(document.body);
            // });
        },
        send : function (e,data) {
            $.blockUI({ css: {
                border: 'none',
                padding: '15px',
                backgroundColor: '#000',
                'border-radius': '5px',
                opacity: .7,
                color: '#fff'
            },
            message:  '<h3>上传中请稍候</h3>'  });
        },
        progressall: function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            //TODO
        }
    });
}

function reqOperator(url_m,url_a,id,data){
    if (typeof(data)=="undefined"){
        data = {};
    }
    ajax_post({
            m:url_m,a:url_a,
            plus:id,data:data,
            popSuccess:0,
            successCallback:function(json){
            if (json.rstno>0){
                alertPlug.alert("操作成功! ",'s');
                if (json.data.goto_url!=undefined) {
                    window.location.href=json.data.goto_url;
                }

            } else {
                alertPlug.alert(json.data.err.msg);
            }
        }
    });
}

function reqOpInputs(url_m,url_a,id,data,inputs){
    if (typeof(data)=="undefined"){
        data = {};
    }
    $.each(inputs,function(k,v){
        data[v] = $("#"+v).val();
    });
    ajax_post({m:url_m,a:url_a,plus:id,data:data,popSuccess:0,successCallback:function(json){
            if (json.rstno>0){
                alertPlug.alert("操作成功! ",'s');
                if (json.data.goto_url!=undefined) {
                    window.location.href=json.data.goto_url;
                }

            } else {
                alertPlug.alert(json.data.err.msg);
            }
        }
    });
}

function modal_show(m,a,id,data){
    alertPlug.modal({m:m,a:a,id:id,data:data});
}
