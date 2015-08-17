function changeRadioRst(inputName){
    var result = $('input[name=op_'+inputName+']:checked').val();
    $("#"+inputName).val(result);
}

function lock_bind_input() {
    $("#verifycode").attr("disabled", true);
    $("#name").attr("disabled", true);
    $("#bindButton").addClass("pure-button-disabled").removeClass("pure-button-primary");
}

function get_phone_verify() {
    var phone = $("#phone").val();
    var validator = $("#bindForm").validate();

    if (phone == "") {
        return;
    }
    ajax_post({
        m: 'mindex',
        a: 'doGetVerify',
        data: {phone: phone},
        popSuccess: 0,
        successCallback: function(json) {
            if (json.rstno == 1) {
                $("#verify-status").addClass('has-error').html("您的手机号" + phone + "在系统中已存在，请收到验证码后输入验证身份。<br/>验证码有效期10分钟，如未收到1分钟后可重发。");
                $("#verifycode").removeAttr("disabled");
                $("#name").removeAttr("disabled");
                $("#name").val(json.data.name);
                $("#bindButton").removeClass("pure-button-disabled").addClass("pure-button-primary");
            } else {
                $("#verify-status").addClass('has-error').html("您输入的手机号是" + phone + "。请收到验证码后输入验证。<br/>验证码有效期10分钟，如未收到1分钟后可重发。");
                $("#verifycode").removeAttr("disabled");
                $("#name").removeAttr("disabled");
                $("#bindButton").removeClass("pure-button-disabled").addClass("pure-button-primary");
            }
        },
        errorCallback: function(json) {
            $("#verify-status").html('');
            var showErr = {};
            showErr[json.data.err.id] = json.data.err.msg;
            if (validator) {
                validator.showErrors(showErr);
            } else {
                alertPlug.alert(json.data.err.msg);
            }
        },
    });
}

function do_bind() {
    var phone = $("#phone").val();
    var verifycode = $("#verifycode").val();
    var name = $("#name").val();

    var validator = $("#bindForm").validate();

    if (phone == "") {
        return;
    }
    ajax_post({
        m: 'mindex',
        a: 'doVerify',
        data: {phone: phone, name: name, verifycode: verifycode},
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
        errorCallback: function(json) {
            var showErr = {};
            showErr[json.data.err.id] = json.data.err.msg;
            if (validator) {
                validator.showErrors(showErr);
            } else {
                alertPlug.alert(json.data.err.msg);
            }
        },
    });
}

function recreate_order(typ,bookId){
    if (typ == 'u') {
        m = 'uorder';
    } else {
        m = 'morder'
    }
    page_load({m: m,
        a: 'rebook_store',
        plus: bookId,
        typ: 'overlay',
    });
}

function book_store_package(typ,storeId,packageId){
    if ($("#select_car").length>=1){
        var carId = $("#select_car").val();
    } else {
        var carId = false;
    }

    if (typ == 'u') {
        m = 'uorder';
        var uid = $("#uid").val();
        data = {uid:uid, carId: carId, storeId: storeId,packageId:packageId}
    } else {
        m = 'morder';
        data =  {carId: carId, storeId: storeId,packageId:packageId}
    }


    page_load({m: m,
        a: 'book_store_package',
        data: data,
        typ: 'overlay',
    });
}

function book_store(typ,storeId) {
    if ($("#select_car").length>=1){
        var carId = $("#select_car").val();
    } else {
        var carId = false;
    }

    if (typ == 'u') {
        m = 'uorder';
        var uid = $("#uid").val();
        data = {uid:uid, carId: carId, storeId: storeId}
    } else {
        m = 'morder';
        data =  {carId: carId, storeId: storeId}
    }


    page_load({m: m,
        a: 'book_store',
        data: data,
        typ: 'overlay',
    });
}

function view_book(bookId) {
    page_load({m: 'morder',
        a: 'book_store',
        data: {carId: carId, storeId: storeId},
        typ: 'overlay',
    });
}

function edit_car(typ,uid,carId){
    if (typ == 'u') {
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    data = {uid: uid,carId:carId};
    page_load({m: m,
        a: 'editCar',
        data: data,
        typ: 'overlay',
    });
}

function edit_car_chexi(typ,uid,carId,pinpai){
    if (typ == 'u') {
        m = 'uindex';

    } else {
        m = 'mindex';
    }
    data = {uid: uid,carId:carId,pinpai: pinpai};
    page_load({m: m,
        a: 'editCarChexi',
        data: data,
        typ: 'overlay',
    });
}

function edit_car_niankuan(typ,uid,carId, pinpai, chexi) {
    if (typ == 'u') {
        m = 'uindex';

    } else {
        m = 'mindex';
    }
    data = {uid: uid,carId:carId,pinpai: pinpai,chexi:chexi};
    page_load({m: m,
        a: 'editCarNiankuan',
        data: data,
        typ: 'overlay',
    });
}

function edit_car_detail(typ,uid,carId){
    if (typ == 'u') {
        m = 'uindex';

    } else {
        m = 'mindex';
    }
    data = {uid: uid,carId:carId};
    page_load({m: m,
        a: 'editCarDetail',
        data: data,
        typ: 'overlay',
    });
}

function add_car(typ, uid) {
    if (typ == 'u') {
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    data = {uid: uid};
    page_load({m: m,
        a: 'addCar',
        data: data,
        typ: 'overlay',
    });
}

function add_car_chexi(typ, uid, pinpai) {
    if (typ == 'u') {
        m = 'uindex';

    } else {
        m = 'mindex';
    }
    data = {uid: uid, pinpai: pinpai};
    page_load({m: m,
        a: 'addCarChexi',
        data: data,
        typ: 'overlay',
    });
}

function add_car_niankuan(typ, uid, pinpai, chexi) {
    if (typ == 'u') {
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    data = {uid: uid, pinpai: pinpai, chexi: chexi};
    page_load({m: m,
        a: 'addCarNiankuan',
        data: data,
        typ: 'overlay',
    });
}

function select_car_niankuan(typ, uid, pinpai, chexi, niankuan) {
    if (typ == 'u') {
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    data = {uid: uid, pinpai: pinpai, chexi: chexi, niankuan: niankuan};
    page_load({m: m,
        a: 'addCarDetail',
        data: data,
        typ: 'overlay',
    });
}

function del_car(typ,uid,id) {
    if (typ=='u'){
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    data = {uid:uid,id:id};
    ajax_post({
        m: m,
        a: 'doDelCar',
        plus: id,
        data: data,
        popSuccess:0,
        successCallback: function(json) {
             window.location.href = json.data.goto_url;
        },
        errorCallback: function(json) {
            var showErr = {};
            showErr[json.data.err.id] = json.data.err.msg;
            if (validator) {
                validator.showErrors(showErr);
            } else {
                alertPlug.alert(json.data.err.msg);
            }
        }
    });
}

function del_bind(typ,uid,id) {
    if (typ=='u'){
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    data = {uid:uid,id:id};
    ajax_post({
        m: m,
        a: 'doDelBind',
        data: data,
        popSuccess:0,
        successCallback: function(json) {
             window.location.href = json.data.goto_url;
        },
        errorCallback:function(json) {
            var showErr = {};
            showErr[json.data.err.id] = json.data.err.msg;
            if (validator) {
                validator.showErrors(showErr);
            } else {
                alertPlug.alert(json.data.err.msg);
            }
        }
    });
}

function real_edit_car_niankuan(typ,uid,carId,pinpai, chexi, niankuan) {


    if (typ=='u'){
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    ajax_post({
        m: m,
        a: 'doEditCarNiankuan',
        data: {
            uid: uid,
            carId:carId,
            pinpai: pinpai,
            chexi: chexi,
            niankuan: niankuan,
        },
        popSuccess:0,
        successCallback: function(json) {
             if (json.data.goto_url != undefined) {
                window.location.href = json.data.goto_url;
            }
        }
    });
}

function doChangepwd(typ){
    if (typ=='u'){
        m = 'uindex';
    } else {
        m = 'mindex'
    }

    validator = $("#changePwdForm").validate();

    if (validator.form()==false) {
        return;
    };

    var password = $("#password").val();
    if (password!=$("#password2").val()){
        alert('两次输入不一致！');
        return;
    }

    ajax_post({
        m: m,
        a: 'doChangepwd',
        data: {
            password:password
        },
        popSuccess:0,
        successCallback: function(json) {
            alert('修改成功!');
            $("#password").val('');
            $("#password2").val('');

        }
    });
}

function real_edit_car(typ,uid,carId){
    validator = $("#addCarForm").validate();

    if (validator.form()==false) {
        return;
    };

    if (typ=='u'){
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    ajax_post({
        m: m,
        a: 'doEditCar',
        data: {
            uid: uid,
            carId:carId,
            chepaihao: $("#chepaihao").val(),
            chejiahao: $("#chejiahao").val(),
            fadongji: $("#fadongji").val(),
            regTS: $("#regTS").val()
        },
        popSuccess:0,
        successCallback: function(json) {
             if (json.data.goto_url != undefined) {
                window.location.href = json.data.goto_url;
            }
        }
    });
}

function real_add_car(typ,uid,pinpai, chexi, niankuan) {
    validator = $("#addCarForm").validate();

    if (validator.form()==false) {
        return;
    };

    if (typ=='u'){
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    ajax_post({
        m: m,
        a: 'doAddCar',
        data: {
            uid: uid,
            pinpai: pinpai,
            chexi: chexi,
            niankuan: niankuan,
            chepaihao: $("#chepaihao").val(),
            chejiahao: $("#chejiahao").val(),
            fadongji: $("#fadongji").val(),
            regTS: $("#regTS").val()
        },
        popSuccess:0,
        popError:0,
        successCallback: function(json) {
             if (json.data.goto_url != undefined) {
                window.location.href = json.data.goto_url;
            }
        },
        errorCallback: function(json) {
            var showErr = {};
            showErr[json.data.err.id] = json.data.err.msg;
            if (validator) {
                validator.showErrors(showErr);
            } else {
                alertPlug.alert(json.data.err.msg);
            }
        }
    });
}

function real_add_book_package(typ,carId,orgId,packageId){
    carId = $("#real_select_car").val();
    if (typ=='u'){
        m = 'uorder';
        data =  {
            uid:$("#uid").val(),
            carId: carId,
            orgId: orgId,
            packageId: packageId,
            bookTS: $("#bookTS").val(),
        };
    } else {
        m = 'morder';
        data =  {
            carId: carId,
            orgId: orgId,
            packageId: packageId,
            bookTS: $("#bookTS").val(),
        };
    }
    ajax_post({
        m: m,
        a: 'doAddBookWithPackage',
        data:data,
        popSuccess: 0,
        successCallback: function(json) {
            if (typ=='u'){
                window.location.href = json.data.goto_url;
            } else {
                $("#book-page").addClass("hide");
                $("#result-page").removeClass("hide");
            }

        },
    });
}

function real_add_book(typ,carId, orgId) {
    carId = $("#real_select_car").val();
    if (typ=='u'){
        m = 'uorder';
        data =  {
            uid:$("#uid").val(),
            carId: carId,
            orgId: orgId,
            typ: $("#select_typ").val(),
            bookTS: $("#bookTS").val(),
            bookdesc:$("#bookdesc").val()
        };
    } else {
        m = 'morder';
        data =  {
            carId: carId,
            orgId: orgId,
            typ: $("#select_typ").val(),
            bookTS: $("#bookTS").val(),
            bookdesc:$("#bookdesc").val()
        };
    }
    ajax_post({
        m: m,
        a: 'doAddBook',
        data:data,
        popSuccess: 0,
        successCallback: function(json) {
            if (typ=='u'){
                window.location.href = json.data.goto_url;
            } else {
                $("#book-page").addClass("hide");
                $("#result-page").removeClass("hide");
            }

        },
    });
}

function showAddPeijian(bookId){
    page_load({m: 'uorder',
        a: 'showAddPeijian',
        data:{bookId:bookId},
        typ: 'double_overlay',
    });
}
function showAddService(bookId){
    page_load({m: 'uorder',
        a: 'showAddService',
        data:{bookId:bookId},
        typ: 'double_overlay',
    });
}



function u_create(typ){
    if (typ=='u'){
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    page_load({m: m,
        a: 'createUser',
        typ: 'overlay',
    });
}

function do_updateUser(typ,id){
    if (typ=='u'){
        m = 'uindex';
    } else {
        m = 'mindex'
    }

    ajax_post({
        m: m,
        a: 'doEditUser',
        data:{uid: id,phone:$("#phone").val(),name:$("#name").val()},
        popSuccess:0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function do_u_create(){
    ajax_post({
        m: 'uindex',
        a: 'doCreateUser',
        data:{phone:$("#phone").val(),name:$("#name").val()},
        popSuccess:0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function cancel_order(typ,orderId) {
    if (!confirm('确认要取消这个订单么？')){
        return;
    }
    if (typ=='u'){
        m = 'uorder';
    } else {
        m = 'morder'
    }
    ajax_post({
        m: m,
        a: 'doCancelOrder',
        plus: orderId,
        popSuccess:0,
        successCallback: function(json) {
            if (typ=='m'){
                alertPlug.confirmCon('cancel_book_success');
            } else {
                window.location.href = json.data.goto_url;
            }
        },
    });
}

function recalcTotalMoney() {
    var total = 0;
    $.each(totalMoney, function(id, value) {
        if ($("#check_" + id).prop('checked')) {
            total += value;
        }
    });
    $("#totalMoney").html(total);
}

function cancel_confirm_book(typ,id){
    if (!confirm('确认返回预检？')){
        return;
    }
    if (typ == 'u') {
        m = 'uorder';
    } else {
        m = 'morder'
    }

    ajax_post({
        m: m,
        a: 'doCancelConfirmBook',
        data: {bookId: id},
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function cancel_shigong(typ,id) {
    var totalId  = [];
    $.each(totalShigong, function(id, value) {
        if ($("#check_" + id).prop('checked')) {
            totalId.push(id);
        }
    });
    if (typ == 'u') {
        m = 'uorder';
    } else {
        m = 'morder'
    }
    ajax_post({
        m: m,
        a: 'doCancelShigong',
        data: {bookId: id, totalId: totalId},
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function confirm_book(typ,id) {
    if (typ == 'u') {
        m = 'uorder';
    } else {
        m = 'morder'
    }

    var totalId = {yuyuefuwu: [], jiance: []};
    $.each(totalMoney, function(id, value) {
        if ($("#check_" + id).prop('checked')) {
            totalId[$("#check_" + id).data('type')].push(id);
        }
    });
    ajax_post({
        m: m,
        a: 'doConfirmBook',
        data: {bookId: id, totalId: totalId},
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function confirm_shigongFinish(id){
    if (!confirm('确认结束施工？')){
        return;
    }
    ajax_post({
        m: 'uorder',
        a: 'doConfirmShigongFinish',
        plus: id,
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function confirm_pay(id){
    if (!confirm('确认已经支付？')){
        return;
    }
    var data = {
        payMethod:$('#modify_payMethod').val()
    }
    ajax_post({
        m: 'uorder',
        a: 'doConfirmPay',
        plus: id,
        data: data,
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function view_car(typ,uid,carId){
    if (typ == 'u') {
        m = 'uindex';
    } else {
        m = 'mindex'
    }
    page_load({m: m,
        a: 'view_car',
        data: {uid:uid,carId:carId},
        typ: 'overlay',
    });
}

function view_complain(typ,id) {
    if (typ == 'u') {
        m = 'uorder';
    } else {
        m = 'morder'
    }
    page_load({m: m,
        a: 'complain',
        plus: id,
        typ: 'overlay',
    });
}

function view_store(id) {
    page_load({m: 'morder',
        a: 'view_store',
        plus: id,
        typ: 'overlay',
    });
}

function load_user(id) {
    page_load({m: 'uindex',
        a: 'info',
        plus: id,
        typ: 'overlay',
    });
}


function confirm_tousu(typ,id) {
    if (typ == 'u') {
        m = 'uorder';
    } else {
        m = 'morder'
    }
    ajax_post({
        m: m,
        a: 'doConfirmTousu',
        plus: id,
        data: {complain_typ: $("#complain_typ").val(),complain_desc:$("#complain_desc").val()},
        popSuccess: 0,
        successCallback: function(json) {
            alertPlug.confirmCon('confirm_tousu_success');
        },
    });
}

function cancel_tousu_typ(typ,id,method) {

    if (typ == 'u') {
        m = 'uorder';
        if ($("#genzong").val()==""){
            alertPlug.alert("请输入故障跟踪以备核查");
            return;
        }
        data = {genzong:$("#genzong").val()};
    } else {
        m = 'morder';
        data = {};
    }
    ajax_post({
        m: m,
        a: 'doCancelTousu',
        plus: id+'/'+method,
        data: data,
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}


function confirm_yanshou(typ,id) {
    if (typ == 'u') {
        m = 'uorder';
    } else {
        m = 'morder'
    }
    ajax_post({
        m: m,
        a: 'doConfirmYanshou',
        data: {bookId: id},
        popSuccess: 0,
        successCallback: function(json) {
            alert('请您至前台处付款以便完成后续的交付');
            window.location.href = json.data.goto_url;

            // alertPlug.confirmCon('confirm_yanshou_success');
        },
    });
}

function confirm_score(typ,id) {
    if (typ == 'u') {
        m = 'uorder';
    } else {
        m = 'morder'
    }
    data = {
        hj_score:$("#hj_score_input").val(),
        score:$("#score_input").val(),
        jishi_score:$("#jishi_score_input").val(),
        kh_score:$("#kh_score_input").val(),
        score_cont:$("#score_cont").val(),
    };

    ajax_post({
        m: m,
        a: 'doConfirmScore',
        plus:id,
        data: data,
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function search_by_direct(status){
    window.location.href = req_url_template.str_supplant({ctrller:'uorder',action:'lists'})+'/'+status+'/all';
}

function search_by_status(){
    var status = $("#search_by_status").val();
    window.location.href = req_url_template.str_supplant({ctrller:'uorder',action:'lists'})+'/'+status+'/all';
}

function search_by_chepai(){
    var user = $("#search_by_chepai").val();
    window.location.href = req_url_template.str_supplant({ctrller:'uorder',action:'lists'})+'/-1/'+user;
}

function search_huiku_by_chepai(){
    var user = $("#search_by_chepai").val();
    window.location.href = req_url_template.str_supplant({ctrller:'ustore',action:'huiku'})+'/'+user;
}

function show_goback_yujian(id){
    if (!confirm('确认返回预检？')){
        return;
    }
    page_load({m: 'uorder',
        a: 'goBackYujian',
        plus: id,
        typ: 'overlay',
    });
}

function u_add_yuyuefuwu(){
    page_load({m: 'uorder',
        a: 'addService',
        typ: 'overlay',
    });
}

function check_yujian(orderId,yujianId){
    page_load({m: 'morder',
        a: 'checkYujian',
        plus: orderId+'/'+yujianId,
        typ: 'overlay',
    });
}



function add_yuyuefuwu(orderId,step_id,yuyueweixiuId){
    page_load({m: 'uorder',
        a: 'addYuyuefuwu',
        plus: orderId+'/'+step_id+'/'+yuyueweixiuId,
        typ: 'overlay',
    });
}

function del_yuyuefuwu(orderId,yuyueweixiuId){
    ajax_post({
        m: 'uorder',
        a: 'doDelYuyuefuwu',
        plus: orderId+'/'+yuyueweixiuId,
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function change_yujian(orderId,yujianId,step_id){
    page_load({m: 'uorder',
        a: 'addYujian',
        plus: orderId+'/'+yujianId+'/'+step_id,
        typ: 'overlay',
    });
}

function change_order(id){
    validator = $("#yuyueForm").validate();

    if (validator.form()==false) {
        alert('输入有误');
        return;
    };
    var jishiList = [];
    $.each($(".check_jishi"),function(k,v){
        if ($(this).prop("checked")){
            jishiList.push($(this).val());
        }
    });


    var data = {
        typ:$("#typ").val(),
        bookdesc:$("#bookdesc").val(),
        estimateTime:$("#estimateTime").val(),
        estimateMoney:$("#estimateMoney").val(),
        bookTS:$("#bookTS").val(),
        jishi:jishiList
    }
    ajax_post({
        m: 'uorder',
        a: 'doChangeOrder',
        plus: id,
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function confirm_order(id){
    validator = $("#yuyueForm").validate();

    if (validator.form()==false) {
        alert('输入有误');
        return;
    };
    var jishiList = [];
    $.each($(".check_jishi"),function(k,v){
        if ($(this).prop("checked")){
            jishiList.push($(this).val());
        }
    });
    if (jishiList.length==0){
        alertPlug.alert('请至少选择一位技师！');
        return;
    }

    var data = {
        typ:$("#typ").val(),
        bookdesc:$("#bookdesc").val(),
        estimateTime:$("#estimateTime").val(),
        estimateMoney:$("#estimateMoney").val(),
        bookTS:$("#bookTS").val(),
        jishi:jishiList
    }
    ajax_post({
        m: 'uorder',
        a: 'doConfirmOrder',
        plus: id,
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function confirm_yujianquickFinish(id){
    ajax_post({
        m: 'uorder',
        a: 'doConfirmYujianQuickFinish',
        plus: id,
        popSuccess:0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

function confirm_yujianFinish(id){
    var data = {kilometers:$("#kilometers").val()};
    ajax_post({
        m: 'uorder',
        a: 'doConfirmYujianFinish',
        plus: id,
        data:data,
        popSuccess:0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}

/*service*/
var searchServiceResult = {};
function search_service(bookId){
    var data = {
        service_typ:$("#service_typ").val(),
        service_name:$("#service_name").val(),
        bookId:bookId
    }
    var template = '<li id="{_id}"  class="data" onclick="user_search_service(\'{_id}\')">{name} : {biaoshi}, 价格{jiage}</li>';
    ajax_post({
        m: 'udata',
        a: 'searchService',
        data: data,
        popSuccess:0,
        autoBlock:0,
        successCallback: function(json) {
            $("#search_result_op").removeClass('hide');
            $("#service_search").html('');
            $.each(json.data,function(k,v){
                searchServiceResult[v._id] = v;
                $("#service_search").append(template.str_supplant(v));
            });

            // window.location.href = json.data.goto_url;
        },
    });
}

function user_search_service(_id){

    var data = searchServiceResult[_id];
    console.log(data);
    $("#service_xinghaoId").val(_id);
    $("#service_search li").removeClass('list-data-sel').removeClass('hover');
    $("#"+_id).addClass('list-data-sel').addClass('hover');
    var template = '{name} : {biaoshi}, 价格{jiage}';
    $("#what_choosed").html(template.str_supplant(searchServiceResult[_id]));
    $("#service_chengben").val(data.chengben);

}

function remove_service_lock(){
    $("#service_xinghaoId").val(0);
    $("#service_baoxiu").prop("readonly",false);
    $("#service_jiage").prop("readonly",false);
}

function createNewService(bookId){
    validator = $("#new_service_form").validate();

    if (validator.form()==false) {
        alert('输入有误');
        return;
    };
    var data = {
        bookId:bookId,
        typ:$("#new_service_typ").val(),
        name:$("#new_service_name").val(),
        biaoshi:$("#new_service_biaoshi").val(),
        jiage:$("#new_service_jiage").val(),
        chengben:$("#new_service_chengben").val(),

    };
    var template = '<li id="{_id}"  class="data" onclick="user_search_service(\'{_id}\')">{name} : {biaoshi}, 价格{jiage}</li>';
    ajax_post({
        m: 'udata',
        a: 'doCreateNewService',
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            var newId = json.data.newId;
            data['_id'] = newId;
            searchServiceResult[newId] =data;
            $("#service_search").append(template.str_supplant(data));
            user_search_service(newId);
            clearNewService();
            $("#search_result_op").removeClass('hide');
            // window.location.href = json.data.goto_url;
        },
    });
}


function addService(){
    var newId = 0 - new Date().getTime();
    var xinghaoId = $("#service_xinghaoId").val();
    var counter = $("#service_count").val();

    allServices[newId] = {
        _id:newId,
        xinghaoId:xinghaoId,
        typ:searchServiceResult[xinghaoId].typ,
        name:searchServiceResult[xinghaoId].name,
        biaoshi:searchServiceResult[xinghaoId].biaoshi,
        jiage:searchServiceResult[xinghaoId].jiage,
        gongshi:searchServiceResult[xinghaoId].gongshi,
        counter:counter,
    };
    if (allServices[newId].name=="" && allServices[newId].biaoshi==""){
        delete allServices[newId];
        alertPlug.alert('信息输入不全');
        return;
    }
    refreshServiceShow();
    clearService();
    closeOverlay();
}

function removeServiceLine(id){
    delete allServices[id];
    refreshServiceShow();
}

function refreshServiceShow(changed){
    var template = '<li class="list-group-item" onclick="removeServiceLine(\'{_id}\')">{name}:{biaoshi} 数量{counter} ,价格{jiage} <a href="javascript:void(0);"> <i class="fa fa-remove"></i> </a></li>';
    $("#table_services").html('');
    var totalPrice = 0;
    $.each(allServices,function(k,v){
        $("#table_services").append(template.str_supplant(v));
        totalPrice+=myParseFloat(v.jiage*v.counter);
    });

    servicePrices.gongshifei = totalPrice;
    caclTotalServicePrice();
}

function clearNewService(){
    $("#new_service_typ").val(0);
    $("#new_service_name").val('');
    $("#new_service_pinpai").val('');

    $("#new_service_biaoshi").val('');
    $("#new_service_xinghao").val('');
    $("#new_service_gongshi").val('');
    $("#new_service_baoxiu").val('');
    $("#new_service_jiage").val('');
    $("#new_service_counter").val('');

    $('#create_service').addClass('hide')
}
function clearService(){
    $("#service_search").html('');
    $("#service_xinghaoId").val(0);
    $("#service_typ").val(0);
    $("#service_name").val('');
    $("#search_result_op").addClass('hide');
}
/* end service*/

/* begin peijian*/
var searchPeijianResult = {};
function search_peijian(bookId){
    var data = {
        peijian_typ:$("#peijian_typ").val(),
        peijian_name:$("#peijian_name").val(),
        bookId:bookId
    }
    var template = '<li id="{_id}"  class="data" onclick="user_search_peijian(\'{_id}\')">{pinpai} - {name} : {biaoshi} {xinghao} , 工时{gongshi},剩余{counter}</li>';
    ajax_post({
        m: 'udata',
        a: 'searchPeijian',
        data: data,
        popSuccess:0,
        autoBlock:0,
        successCallback: function(json) {
            $("#search_result_op").removeClass('hide');
            $("#peijian_search").html('');
            $.each(json.data,function(k,v){
                searchPeijianResult[v._id] = v;
                $("#peijian_search").append(template.str_supplant(v));
            });

            // window.location.href = json.data.goto_url;
        },
    });
}


function user_search_peijian(_id){

    var data = searchPeijianResult[_id];
    console.log(data);
    $("#peijian_xinghaoId").val(_id);
    $("#peijian_search li").removeClass('list-data-sel').removeClass('hover');
    $("#"+_id).addClass('list-data-sel').addClass('hover');
    var template = '{pinpai} - {name} : {biaoshi} {xinghao} , 剩余{counter}';
    $("#what_choosed").html(template.str_supplant(searchPeijianResult[_id]));
    $("#peijian_chengben").val(data.chengben);

}

function remove_peijian_lock(){
    $("#peijian_xinghaoId").val(0);
    $("#peijian_baoxiu").prop("readonly",false);
    $("#peijian_jiage").prop("readonly",false);
}

function clearNewPeijian(){
    $("#new_peijian_typ").val(0);
    $("#new_peijian_name").val('');
    $("#new_peijian_pinpai").val('');

    $("#new_peijian_biaoshi").val('');
    $("#new_peijian_xinghao").val('');
    $("#new_peijian_gongshi").val('');
    $("#new_peijian_baoxiu").val('');
    $("#new_peijian_jiage").val('');
    $("#new_peijian_counter").val('');

    $('#create_peijian').addClass('hide')
}
function clearPeijian(){
    $("#peijian_search").html('');
    $("#peijian_xinghaoId").val(0);
    $("#peijian_typ").val(0);
    $("#peijian_name").val('');
    $("#search_result_op").addClass('hide');
}


function createNewPeijian(bookId){
    validator = $("#new_peijian_form").validate();

    if (validator.form()==false) {
        alert('输入有误');
        return;
    };
    var data = {
        bookId:bookId,
        typ:$("#new_peijian_typ").val(),
        name:$("#new_peijian_name").val(),
        pinpai:$("#new_peijian_pinpai").val(),
        biaoshi:$("#new_peijian_biaoshi").val(),
        xinghao:$("#new_peijian_xinghao").val(),
        baoxiu:$("#new_peijian_baoxiu").val(),
        jiage:$("#new_peijian_jiage").val(),
        gongshi:$("#new_peijian_gongshi").val(),
        // counter:$("#new_peijian_counter").val(),
        chengben:$("#new_peijian_chengben").val(),

    };
    var template = '<li id="{_id}"  class="data" onclick="user_search_peijian(\'{_id}\')">{pinpai} - {name} : {biaoshi} {xinghao} , 工时{gongshi},剩余{counter}</li>';
    ajax_post({
        m: 'udata',
        a: 'doCreateNewPeijian',
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            var newId = json.data.newId;
            data['_id'] = newId;
            data['counter'] = 0;
            searchPeijianResult[newId] =data;
            $("#peijian_search").append(template.str_supplant(data));
            user_search_peijian(newId);
            clearNewPeijian();
            $("#search_result_op").removeClass('hide');
            // window.location.href = json.data.goto_url;
        },
    });
}

function addPeijian(){
    var newId = 0 - new Date().getTime();
    var xinghaoId = $("#peijian_xinghaoId").val();
    var counter = $("#peijian_count").val();
    var chengben = myParseFloat($("#peijian_chengben").val());
    var isKuaisu = 0;
    if ($("#peijian_kuaisu").prop('checked')){
        isKuaisu = 1;
    }
    var isZidai = 0;
    if ($("#peijian_zidai").prop('checked')){
        isZidai = 1;

    }
    if (isZidai==1 && isKuaisu==1){
        alert('客户自带配件和快速出入库不可同时选择！');
        return;
    }
    if (isKuaisu==0 && isZidai==0 && searchPeijianResult[xinghaoId].counter<=0){
        alert('当前库存为零！请采购入库或者选择快速出入库进货！');
        return;
    }

    allPeijians[newId] = {
        _id:newId,
        xinghaoId:xinghaoId,
        typ:searchPeijianResult[xinghaoId].typ,
        name:searchPeijianResult[xinghaoId].name,
        pinpai:searchPeijianResult[xinghaoId].pinpai,
        xinghao:searchPeijianResult[xinghaoId].xinghao,
        biaoshi:searchPeijianResult[xinghaoId].biaoshi,
        baoxiu:searchPeijianResult[xinghaoId].baoxiu,
        jiage:searchPeijianResult[xinghaoId].jiage,
        gongshi:searchPeijianResult[xinghaoId].gongshi,
        counter:counter,
        isKuaisu:isKuaisu,
        chengben:chengben,
        isZidai:isZidai
    };
    if (isZidai==1){
        allPeijians[newId].jiage = 0;
        allPeijians[newId].baoxiu = 0;

    }
    if (allPeijians[newId].name=="" && allPeijians[newId].pinpai==""){
        delete allPeijians[newId];
        alertPlug.alert('信息输入不全');

        return;
    }
    refreshPeijianShow();
    clearPeijian();
    closeOverlay();
}

function removePeijianLine(id){
    delete allPeijians[id];
    refreshPeijianShow();
}

function refreshPeijianShow(changed){
    var template = '<li class="list-group-item" onclick="removePeijianLine(\'{_id}\')">{pinpai} - {name} : {xinghao}/{biaoshi} 数量{counter} 工时{gongshi},价格{jiage} {zidai}<a href="javascript:void(0);"> <i class="fa fa-remove"></i> </a></li>';
    $("#table_peijians").html('');
    var totalPrice = 0;
    var totalGongshi = 0;
    var baseGongshiFei = 40;
    $.each(allPeijians,function(k,v){
        if (v.isZidai){
            v.zidai = '(自带)';
        } else {
            v.zidai = '';
        }
        $("#table_peijians").append(template.str_supplant(v));
        if (v.isZidai==0){
            totalPrice+=myParseFloat(v.jiage*v.counter);
        }
        totalGongshi+=myParseFloat(v.gongshi*v.counter);
    });


    peijianPrices.peijianfei = totalPrice;
    peijianPrices.gongshifei = totalGongshi*baseGongshiFei;

    caclTotalServicePrice();
}

/*记录工时费手动修改*/
function mannualChangeGongshiFei(){
    var nowGongshi = $("#gongshifei").val();
    totalPrices.gongshiDiff = nowGongshi - totalPrices.gongshifei;
    caclTotalServicePrice();
}
function mannualChangeJiChuGongShi(){
    caclTotalServicePrice();
}

function caclTotalServicePrice(){
    var baseGongshiFei = 40;

    var jichugongshi =  myParseFloat($("#jichugongshi").val());
    totalPrices.peijianfei = peijianPrices.peijianfei;
    totalPrices.gongshifei = peijianPrices.gongshifei + servicePrices.gongshifei + jichugongshi*baseGongshiFei;
    totalPrices.youhui = myParseFloat($("#youhui").val());
    totalPrices.jiage = totalPrices.peijianfei+totalPrices.gongshifei-totalPrices.youhui+ totalPrices.gongshiDiff;

    if ($("#peijianfei").length>0){
        $("#peijianfei").val(totalPrices.peijianfei);
        $("#gongshifei").val(totalPrices.gongshifei + totalPrices.gongshiDiff);
        $("#jiage").val(totalPrices.jiage);
    }
}
/* end peijian*/

/* begin ruku*/

function search_peijian_store(opTyp){
    $("#peijian_search").html('');
    var data = {
        peijian_typ:$("#peijian_typ").val(),
        peijian_name:$("#peijian_name").val(),
        peijian_store:$("#peijian_store").val(),
    }
    var template = '<li id="{_id}"  class="data" onclick="ruku_use_peijian(\''+opTyp+'\',\'{_id}\')">{pinpai} - {name} : {biaoshi} {xinghao} , 剩余{counter}</li>';
    ajax_post({
        m: 'udata',
        a: 'searchPeijian',
        data: data,
        popSuccess:0,
        autoBlock:1,
        successCallback: function(json) {
            $("#search_result_op").removeClass('hide');

            $.each(json.data,function(k,v){
                searchPeijianResult[v._id] = v;
                $("#peijian_search").append(template.str_supplant(v));
            });

            // window.location.href = json.data.goto_url;
        },
    });
}
function ruku_use_peijian(opTyp,_id){
    $("#peijian_xinghaoId").val(_id);
    $("#peijian_search li").removeClass('list-data-sel').removeClass('hover');
    $("#"+_id).addClass('list-data-sel').addClass('hover');
    var template = '{pinpai} - {name} : {biaoshi} {xinghao} <br/> 剩余{counter}，当前成本{chengben} ';
    $("#what_choosed").html(template.str_supplant(searchPeijianResult[_id]));
    if (opTyp=='tui'){
        $("#peijian_count").val(searchPeijianResult[_id].counter);
    } else {
        var chengben = searchPeijianResult[_id].chengben;
        if (chengben==0){
            chengben = searchPeijianResult[_id].jinjia;
        }
        $("#peijian_chengben").val(chengben);


    }
}


function createNewPeijianRuku(){
    var data = {
        typ:$("#new_peijian_typ").val(),
        name:$("#new_peijian_name").val(),
        pinpai:$("#new_peijian_pinpai").val(),
        biaoshi:$("#new_peijian_biaoshi").val(),
        xinghao:$("#new_peijian_xinghao").val(),
        baoxiu:$("#new_peijian_baoxiu").val(),
        jiage:$("#new_peijian_jiage").val(),
        gongshi:$("#new_peijian_gongshi").val(),
        counter:$("#new_peijian_counter").val(),
        chengben:$("#new_peijian_chengben").val(),
        orgId:$("#peijian_store").val(),
    };
    ajax_post({
        m: 'ustore',
        a: 'doRukuCreate',
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}


function rukuPeijian(opTyp){
    if (!confirm('确认操作？')){
        return;
    }
    validator = $("#rukuPeijianForm").validate();

    if (validator.form()==false) {
        alert('输入有误');
        return;
    };
    var newId = 0 - new Date().getTime();
    var xinghaoId = $("#peijian_xinghaoId").val();

    if (xinghaoId=="" || xinghaoId==0){
        alertPlug.alert('信息输入不全');
        return;
    }
    data = {
        xinghaoId:xinghaoId,
        orgId:$("#peijian_store").val(),
        typ:searchPeijianResult[xinghaoId].typ,
        name:searchPeijianResult[xinghaoId].name,
        pinpai:searchPeijianResult[xinghaoId].pinpai,
        xinghao:searchPeijianResult[xinghaoId].xinghao,
        biaoshi:searchPeijianResult[xinghaoId].biaoshi,
        counter:$("#peijian_count").val(),
        chengben:$("#peijian_chengben").val(),
        opTyp:opTyp
    };
    ajax_post({
        m: 'ustore',
        a: 'doRuku',
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });

}
/* end ruku*/

/* begin biaozhun */
function show_biaozhun(typ,bookId,biaozhunId){
    page_load({m: 'udata',
        a: 'showBiaozhun',
        plus: typ+'/'+biaozhunId+'/'+bookId,
        typ: 'overlay',
    });
}

function add_biaozhun(orderId,typ){
    page_load({m: 'uorder',
        a: 'addBiaozhun',
        plus: orderId+'/'+typ,
        typ: 'overlay',
    });
}


var searchBiaozhunResult = {};
function search_biaozhun(bookId,typ) {
    var data = {
        bookId:bookId,
        typ:typ,
        keyword:$("#searchBiaozhun").val(),
    }
    if (typ=="weixiu"){
        var template = '<li id="{_id}"  class="list-group-item" onclick="show_biaozhun(\''+typ+'\',\''+bookId+'\',\'{_id}\')">{showId} - {name}.<br/>{desc}. {look_1} : {look_2}<br/> {suggest}</li>';
    } else if (typ=="baoyang" || typ=="meirong") {
        var template = '<li id="{_id}"  class="list-group-item" onclick="show_biaozhun(\''+typ+'\',\''+bookId+'\',\'{_id}\')">{showId} - {name}.<br/>{desc}<br/> {suggest}</li>';
    }

    ajax_post({
        m: 'udata',
        a: 'searchBiaozhun',
        data: data,
        popSuccess:0,
        autoBlock:0,
        successCallback: function(json) {
            $("#searchBiaozhunResult").html('');
            $.each(json.data,function(k,v){
                searchBiaozhunResult[v._id] = v;
                $("#searchBiaozhunResult").append(template.str_supplant(v));
            });
            // window.location.href = json.data.goto_url;
        },
    });
}

function show_default_biaozhun(typ,data,bookId){
    if (typ=="weixiu"){
        var template = '<li id="{_id}"  class="list-group-item" onclick="show_biaozhun(\''+typ+'\',\''+bookId+'\',\'{_id}\')">{showId} - {name}.<br/>{desc}. {look_1} : {look_2}<br/> {suggest}</li>';
    } else if (typ=="baoyang" || typ=="meirong") {
        var template = '<li id="{_id}"  class="list-group-item" onclick="show_biaozhun(\''+typ+'\',\''+bookId+'\',\'{_id}\')">{showId} - {name}.<br/>{desc}<br/> {suggest}</li>';
    }
    $("#searchBiaozhunResult").html('');
    $.each(data,function(k,v){
        searchBiaozhunResult[v._id] = v;
        $("#searchBiaozhunResult").append(template.str_supplant(v));
    });
}

function select_biaozhun(typ,id){

    $("#searchBiaozhun"+typ+"Result li").removeClass('active');
    $("#biaozhun_"+typ+"_"+id).addClass('active');
    useBiaoZhuanPeijian = {};
    useBiaoZhuanPeijian[id] = 1;

}

function choose_biaozhun(typ,bookId,biaozhunId){
    var peijianId = "";
    var selectedP = $("#searchBiaozhunpeijianResult input[type='radio']:checked");
    if (selectedP.length > 0) {
        peijianId = selectedP.val();
    }
    if (biaozhunNeedPeijian && peijianId==""){
        alert('配件尚未选择');
        return;
    }
    var serviceId = "";
    var selectedS = $("#searchBiaozhunserviceResult input[type='radio']:checked");
    if (selectedS.length > 0) {
        serviceId = selectedS.val();
    }
    if (biaozhunNeedService && serviceId==""){
        alert('服务尚未选择');
        return;
    }

    // var peijianId = $("#searchBiaozhunResult").data('use');

    var data = {
        typ:typ,
        bookId:bookId,
        biaozhunId:biaozhunId,
        peijianId:peijianId,
        serviceId:serviceId,
    };
    ajax_post({
        m: 'udata',
        a: 'doChooseBiaozhun',
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            add_yuyuefuwu(bookId,1,json.data.newId);
            // window.location.href = json.data.goto_url;
        },
    });
}

/* end biaozhun*/

function openPhotoSwipe(id,allPic){
    var gallery = new PhotoSwipe( $(".pswp")[0], PhotoSwipeUI_Default, allPic, {index:id-1,bgOpacity:0.9,shareButtons:[]});
    gallery.init();
}

function del_user(userId){

    if (!confirm('确认删除用户？一旦删除无法恢复！只能删除没有订单的用户！')){
        return;
    }
    ajax_post({
        m: 'uindex',
        a: 'doDeleteUser',
        plus: userId,
        popSuccess:0,
        successCallback: function(json) {


            window.location.href = json.data.goto_url;
        },
    });
}

function confirm_yujian(book_id,yujian_id,step_id){
    validator = $("#serviceForm").validate();

    if (validator.form()==false) {
        alert('输入有误');
        return;
    };
    var data;
    if (step_id==1){
        data = {
            result:$("#result").val(),
            xtyp:$("#xtyp").val(),
            suggest:$("#suggest").val()
        };
    } else if (step_id==3) {
        data = {
            peijians:allPeijians,
            services:allServices,
            jichugongshi:$("#jichugongshi").val(),
            jiage:$("#jiage").val(),
            peijianfei:$("#peijianfei").val(),
            gongshifei:$("#gongshifei").val(),
            youhui:$("#youhui").val()
        };
    }
    ajax_post({
        m: 'uorder',
        a: 'doConfirmYujianweixiu',
        plus: book_id+'/'+yujian_id+'/'+step_id,
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            if (step_id==1){
                change_yujian(book_id,yujian_id,2);
            } else {
                window.location.href = json.data.goto_url;
            }
            //console.log(json);

        },
    });
}

function quick_finish_book(typ,book_id){
    if (!confirm('确认要提前结束这个订单么？')){
        return;
    }

    if (typ == 'u') {
        m = 'uorder';
    } else {
        m = 'morder'
    }


    ajax_post({
        m: m,
        a: 'doQuickFinishBook',
        plus:book_id,
        popSuccess: 0,
        successCallback: function(json) {
            window.location.href = json.data.goto_url;
        },
    });
}
function doCreateYuyuefuwu(book_id,yuyuefuwuId){
    validator = $("#serviceForm").validate();

    if (validator.form()==false) {
        alert('输入有误');
        return;
    };
    var data = {
        xtyp:$("#xtyp").val(),
        name:$("#name").val(),
        desc:$("#desc").val(),
        suggest:$("#suggest").val(),
    }
    ajax_post({
        m: 'uorder',
        a: 'doCreateYuyueweixiu',
        plus: book_id+'/'+yuyuefuwuId,
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            add_yuyuefuwu(book_id,2,json.data.newId);
        },
    });
}

function confirm_yuyueweixiu(book_id,yuyuefuwuId){
    validator = $("#serviceForm").validate();

    if (validator.form()==false) {
        alert('输入有误');
        return;
    };
    var data = {

        peijians:allPeijians,
        services:allServices,
        jiage:$("#jiage").val(),
        jichugongshi:$("#jichugongshi").val(),
        peijianfei:$("#peijianfei").val(),
        gongshifei:$("#gongshifei").val(),
        youhui:$("#youhui").val()
    }
    ajax_post({
        m: 'uorder',
        a: 'doConfirmYuyueweixiu',
        plus: book_id+'/'+yuyuefuwuId,
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            //console.log(json);
             window.location.href = json.data.goto_url;
        },
    });
}

//获取验证码 180s有效  间隔60重发
var mobileCodeTimmer;
var mobileCode = {
    get: function()
    {
        var phone = $("#phone").val();
        if (phone == "") {
            $("#verify-status").addClass('has-error').html('手机号不能为空');
            return;
        }
        ajax_post({
            m: 'mtest',
            a: 'doGetVerify',
            popSuccess:0,
            popError:0,
            data: {mobile: phone},
            successCallback: function(json) {
                if (json.data && json.data.count_down) {
                    mobileCode.startCountDown(json.data.count_down);
                }
                if (json.rstno == 1) {
                    $("#verify-status").addClass('has-error').html("您的手机号" + phone + "已存在，请输入验证码验证身份。");
                    $("#verifycode").removeAttr("disabled");
                    $("#name").val(json.data.name);
                    $("#bindButton").removeClass("pure-button-disabled").addClass("pure-button-primary");
                }
            },
            errorCallback: function(json) {
                $("#verify-status").addClass('has-error').html(json.data.err.msg);
                if(json.data && json.data.err.count_down) {
                    mobileCode.startCountDown(json.data.err.count_down);
                }
                $("#verifycode").attr("disabled",'true');
                $("#bindButton").addClass("pure-button-disabled");
            }
        });
        return;
    },
    startCountDown: function(secs) {
        mobileCode.countDown(secs);
    },
    countDown: function(secs) {
        clearTimeout(mobileCodeTimmer);
        $('#codeTimmer').html(secs) ;
        if (--secs > 0) {
            mobileCodeTimmer = setTimeout("mobileCode.countDown(" + secs + ")", 1000);
        } else {
            $("#verify-status").removeClass('has-error').html('请点击验证获取验证码');
            $("#verifycode").attr("disabled",'true');
            $("#bindButton").addClass("pure-button-disabled");
        }
    }
}
function doHuiku(book_id){
    validator = $("#huikuForm").validate();
    if (validator.form()==false) {
        alert('输入有误');
        return;
    };
    var tuipeijian = {};
    $.each(totalPeijians,function(k,v){
        if ($("#check_"+k).prop("checked")) {
            tuipeijian[k] = $("#counter_"+k).val();
        }
    })
    var data = {
        tuipeijian:tuipeijian,

    }
    ajax_post({
        m: 'ustore',
        a: 'doHuiku',
        plus: book_id,
        data: data,
        popSuccess:0,
        successCallback: function(json) {
            //console.log(json);
             window.location.href = json.data.goto_url;
        },
    });
}
