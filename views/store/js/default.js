$(function() {
//    make by Shikaru
/*    clearForm();
    callData(1);
    var keeping = '';
    var store_id = '';
    var store_type_id = ''; */
    
    perPage = 10;
    visiblePages = 7;
    callData("1");
    alertHide();
    
    function callData(id) {
        $.post('store/Pagination', {'store_type_id': id ,'perPage': perPage}, function (o) {
            
            $('.pagin').empty();
            if (o.allPage > 1) {
                $('.pagin').append('<ul id="pagination" class="pagination-sm"></ul>');
                $('#pagination').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages,
                    onPageClick: function (event, page) {
                        //$('.cls').empty();
                        callGetData(id,page);
                        return false;
                    }
                });
            }
            callGetData(id, 1);
        }, 'json');
    }
   
    function callGetData(id, curPage) {
        if (id === "undefined") {
            id = "1";
        }
        //alert('callData');
        $.get('store/xhrGetSelect', {'store_type_id': id,'perPage': perPage, 'curPage': curPage}, function(o) {
            
            $('.cls').empty();    
            for (var i = 0; i < o.length; i++) {
                keeping = o[i].store_type_keeping;
                if (o[i].store_type_keeping === 'serial') {
                    $('#title_stock').text('');
                    $('#title_type').text('SERIAL');
                    stockVal = '';
                    storeVal = o[i].serial_number;
                } else {
                    $('#title_stock').text('STOCK');
                    $('#title_type').text('MAX');
                    stockVal = o[i].store_stock;
                    storeVal = o[i].store_max_count;
                }

                if (o[i].store_closedate === null || (o[i].store_type_keeping === 'value')) {
                    danger = '';
                    manage = '<td align="center">'
                            + '<a class="edit btn btn-info" rel="' + o[i].store_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                            + ' ';

                    if ((o[i].store_stock === o[i].store_max_count) || (o[i].store_closedate === null || (o[i].store_type_keeping === 'serail'))) {
                        manage += '<a class="del btn btn-danger" rel="' + o[i].store_id + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
                    }

                } else {
                    danger = 'danger';
                    manage = '<td align="center"> ' + o[i].store_closedate + ' </td>';

                }
                
                $('#select_data').append('<tr class="delTr' + o[i].store_id + ' cls ' + danger + '"><td>' + o[i].store_id + '</td>'
                        + '<td>' + o[i].store_lotno + '</td>'
                        + '<td style="padding-left:10px">' + o[i].store_type_name + '</td>'
                        + '<td style="padding-left:10px">' + o[i].store_name + '</td>'
                        + '<td align="right">' + formatCurrency(o[i].store_unit_price) + '</td>'
                        + '<td align="center">' + stockVal + '</td>'
                        + '<td align="center">' + storeVal + '</td>'
                        + '<td align="center">' + o[i].store_type_count + '</td>'
                        + '<td align="center">' + o[i].store_adddate + '</td>'
                        + '<td align="center">' + o[i].store_staff + '</td>'
                        + manage
                        + '</tr>'
                        );
            }

            $('.del').on('click', function() {
                $('#div_store_id').hide();
                store_id = $(this).attr('rel');
                delItem = $('.delTr' + store_id);
                
                delConfirmDialog.realize();
//                delConfirmDialog.setMessage("ต้องการลบรายการงานซ่อม \""+tableDt+"\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function() {
                    $.post('store/xhrDeleteById', {'store_id': store_id}, function(o) {
                        if (o.chk) {
                            delItem.empty();
                        } else {
                            alertDialog.setMessage('Primary Key is already use. Cannot Delete !!!.');
                            alertDialog.open();
                        }
                        //callData($('#jobs_group_id_Filter').val());
                        delConfirmDialog.close();
                    }, 'json'); // not use return json data
                });
                delConfirmDialog.open();
                return false;

            });


            $('.edit').on('click', function() {
                $('#show_dialog').click();
                $('#div_store_id').show();
                $('#div_store_stock').show();

                store_id = $(this).attr('rel');

                $.post('store/xhrSelectByID', {'store_id': store_id}, function(o) {
                    $('#store_id').val(o[0].store_id);
                    $('#store_lotno').val(o[0].store_lotno);
                    $('#store_type_id').val(o[0].store_type_id);
                    $('#store_name').val(o[0].store_name);
                    $('#serial_number').val(o[0].serial_number);
                    $('#store_unit_price').val(o[0].store_unit_price);
                    $('#store_stock').val(o[0].store_stock);
                    $('#store_max_count').val(o[0].store_max_count);
                    $('#store_adddate').val(o[0].store_adddate);
                    if (o[0].store_type_keeping === 'serial') {
                        $('#div_serial_number').show();
                        $('#div_store_max_count').hide();
                        $('#div_store_stock').hide();

                    } else if (o[0].store_type_keeping === 'value') {
                        $('#div_serial_number').hide();
                        $('#div_store_max_count').show();
                        $('#div_store_stock').show();
                        $('#store_type_count').text(o[0].store_type_count);
                    }
                    keeping = o[0].store_type_keeping;
                    $('#store_type_keeping').val(o[0].store_type_keeping);
                    $('#store_lotno').focus();
                }, 'json');
   callData(store_type_id);
                return false;
            });
        }, 'json');
    }


    $('#show_dialog').on('click', function() {
       $('#store_type_keeping').val(keeping);
        clearForm();

    });

    $('#btn_reset').on('click', function() {
        clearForm();
//        return false;
    });

    $('#btn_submit').on('click', function() {
        if ($('#store_id').val() !== "") {
            if (confirm("This data is Editing are you sure!\nEnter OK or Cancel.")) {
                $('#store').attr("action", 'store/xhrEditById');
            } else {
                return false;
                exit();
            }
        } else {
            $('#store').attr("action", 'store/xhrInsert');
        }

        $('#store').submit();
        $('.input-store-dialog').modal("toggle");
        
        callData($('#store_type_id').val());
        return true;
        
    });

    $('#store_type_id').on('change', function() {
        $('.cls').empty();
        callData(this.value);
        keeping = this.options[this.selectedIndex].getAttribute('data-store-type');
        var typeCount = this.options[this.selectedIndex].getAttribute('data-type-count');
        if (keeping === 'serial') {
            $('#store_max_count').val(1);
            $('#div_serial_number').show();
            $('#div_store_max_count').hide();
            $('#div_store_stock').hide();
        } else if (keeping === 'value') {
            $('#serial_number').val("");
            $('#div_serial_number').hide();
            $('#div_store_max_count').show();
            $('#div_store_stock').show();
            $('#store_type_count').text(typeCount);
        }
        $('#store_type_keeping').val(keeping);
    });

    $('#show_store_type_id').on('change', function() {
        store_type_id = this.value; 
        $('#store_type_id').val(this.value);
        $('.cls').empty();
        callData(this.value);
        keeping = this.options[this.selectedIndex].getAttribute('data-store-type');
        var typeCount = this.options[this.selectedIndex].getAttribute('data-type-count');
        if (keeping === 'serial') {
            $('#store_max_count').val(1);
            $('#div_serial_number').show();
            $('#div_store_max_count').hide();
            $('#div_store_stock').hide();
        } else if (keeping === 'value') {
            $('#serial_number').val("");
            $('#div_serial_number').hide();
            $('#div_store_max_count').show();
            $('#div_store_stock').show();
            $('#store_type_count').text(typeCount);
        }
        $('#store_type_keeping').val(keeping);
    });

    function clearForm() {
        $('#store_id').val("");
        $('#store_lotno').val("");
        $('#store_name').val("");
        $('#serial_number').val("");
        $('#store_stock').val("");
        $('#store_max_count').val("1");
        $('#store_adddate').datepicker({
            format: "yyyy-mm-dd",
            language: "th",
            autoclose: true,
            todayHighlight: true
        }).datepicker("setDate", new Date());
        $('#div_store_id').hide();

        if (keeping === 'serial') {
            $('#store_max_count').val(1);
            $('#div_serial_number').show();
            $('#div_store_max_count').hide();
            $('#div_store_stock').hide();
        } else if (keeping === 'value') {
            $('#serial_number').val("");
            $('#div_serial_number').hide();
            $('#div_store_max_count').show();
            $('#div_store_stock').show();
        }

    }

    $('#store_stock').on('change', function() {
        if (keeping === 'serial') {
            if (($('#store_stock').val() !== '0') && ($('#store_stock').val() !== '1')) { // 
                alert('กรอกจำนวนไม่ถูกต้อง จำนวนที่กรอกได้ 0 หรือ 1 เท่านั้น');
                $('#store_stock').val('1');
            }
        } else {
            if ((store_id !== '') && (parseInt($('#store_stock').val()) > parseInt($('#store_max_count').val()))) {
                alert('กรอกจำนวนคงเหลือ มากกว่า จำนวนทั้งหมด ไม่ได้!');
                var numMax = $('#store_max_count').val();
                $('#store_stock').val(numMax);
            }

        }
        return false;

    });

    $("#store").validate({
        rules: {
            store_lotno: {required: true},
            store_name: {required: true},
            store_type_id: {required: true},
//            serial_number: {required: true},
            store_max_count: {required: true},
            store_adddate: {required: true}
        },
        messages: {
            store_lotno: {required: "lotno is required!"},
            store_name: {required: "Name is required!"},
            store_type_id: {required: "Type is required!"},
//            serial_number: {required: "SN. is required!"},
            store_max_count: {required: "Number is required!"},
            store_adddate: {required: "Date is required!"}
        },
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function() {
            var url = $("#store").attr('action');
            var data = $("#store").serialize();

            $.post(url, data, function() {
                $('.cls').empty();
                callData($('#store_type_id').val());
            }, 'json');

            clearForm();
            return false;
        }
    });

});