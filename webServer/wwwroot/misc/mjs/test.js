function test_book_store(){

}

function test_view_store(){
	page_load({m:'mtest',
        		a: 'view_store',
        		typ: 'overlay',
        	});
}


function test_book_store(storeId){
	page_load({m:'mtest',
        		a: 'book_store',
        		typ: 'overlay',
        	});
}

function test_cancel_order(storeId){
   ajax_get({m:'mtest',
            a: 'doCancelOrder',
            id:storeId,
            popSuccess:0,
            successCallback:function(){
                //alertPlug.confirmCon('cancel_book_success');
            }
        });
}

function test_view_book(bookId){
	page_load({m:'mtest',
        		a: 'book_store',
        		data: {carId:carId,storeId:storeId},
        		typ: 'overlay',
        	});
}

function test_add_car(){
    page_load({m:'mtest',
                a: 'addCar',
                typ: 'overlay',
            });
}

function test_add_car_chexi(){
    page_load({m:'mtest',
                a: 'addCarChexi',
                typ: 'overlay',
                callback:function(){data_list_hover('list-data-sel')},
            });
}

function test_add_car_niankuan(){
    page_load({m:'mtest',
                a: 'addCarNiankuan',
                typ: 'overlay',
            });
}

function test_select_car_niankuan(){
    page_load({m:'mtest',
                a: 'addCarDetail',
                typ: 'overlay',
            });
}

function test_view_complain(){
    page_load({m:'mtest',
                a: 'complain',
                typ: 'overlay',
            });
}
function test_bind_mobile(){
    page_load({m:'mtest',
                a: 'bind_mobile',
                typ: 'overlay',
            });
}