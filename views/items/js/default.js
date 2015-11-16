$(function() {
//    make by Shikaru
    var perPage = 10;
    var visiblePages = 7;
    var oldItemsGroup = '';
    var oldItemsCode = '';
    var delay = 1000; //1 seconds
    var timer;
    
    $('#search_type_1').prop("checked", true);
    $('#div_show_depart_id,#div_show_hardware_id').hide();

    $("#show_depart_id,#show_hardware_id").addClass("show-tick").selectpicker({
        tickIcon: 'glyphicon-ok',
        liveSearch: true
    });

    clearForm();
    callData(0, 0, ''); // 4,3

    function callData(depart_id, hardware_id, search) {
        $.post('items/Pagination', {'depart_id': depart_id, 'hardware_id': hardware_id, 'search': search, 'perPage': perPage}, function(o) {
            $('.pagin').empty();
            if (o.allPage > 1) {
                $('.pagin').append('<ul id="pagination" class="pagination-sm"></ul>');
                $('#pagination').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages,
                    onPageClick: function(event, page) {
                        $('.cls').empty();
                        callGetData(depart_id, hardware_id, search, page);
                        return false;
                    }
                });
            }
            callGetData(depart_id, hardware_id, search, 1);
        }, 'json');
    }

    function callGetData(depart_id, hardware_id, search, curPage) {
        $.get('items/xhrGetSelect', {'depart_id': depart_id, 'hardware_id': hardware_id, 'search': search, 'perPage': perPage, 'curPage': curPage}, function(o) {
            for (var i = 0; i < o.length; i++) {
                if (o[i].distribute === '1') {
                    color = 'danger';
                } else if (o[i].expire === '1') {
                    color = 'warning';
                } else {
                    color = '';
                }
                $('#select_data').append('<tr class="delTr' + o[i].items_id + ' cls ' + color + '"><td>' + o[i].items_id + '</td>'
                        + '<td>' + o[i].items_code + '</td>'
                        + '<td>' + o[i].sn_scph + '</td>'
                        + '<td>' + o[i].age_y + '</td>'
                        + '<td>' + o[i].hardware_name + '</td>'
                        + '<td>' + o[i].brand + ' ' + o[i].model + '</td>'
                        + '<td>' + o[i].depart_name + '</td>'
                        + '<td align="center">' + o[i].buydate + '</td>'
                        + '<td align="center">' + o[i].expdate + '</td>'
                        + '<td>'
                        + '<a class="edit btn btn-info" rel="' + o[i].items_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].items_id + '" data-items-name="' + o[i].items_name + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        + '</td>'
//                        + '<td align="center"><a class="edit" rel="' + o[i].items_id + '" href="#">Edit</a> | <a class="del" rel="' + o[i].items_id + '" href="#">Delete</a></td>'
                        + '</tr>'
                        );
            }

            $('.del').on('click', function() {
                $('#div_items_id').hide();
                var items_id = $(this).attr('rel');
                delItem = $('.delTr' + items_id);

                delConfirmDialog.realize();
                //delConfirmDialog.setMessage("ต้องการลบประเภทอะไหล่ \"" + $(this).attr("data-storetype-name") + "\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function() {
                    $.post('items/xhrDeleteById', {'items_id': items_id}, function(o) {
                        if (o.chk) {
                            delItem.empty();
                            $('.cls').empty();
                            callData($('#show_depart_id').val(), $('#show_hardware_id').val(), $('#search').val());
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
                $('#div_items_id').show();
                var items_id = $(this).attr('rel');

                $.post('items/xhrSelectByID', {'items_id': items_id}, function(o) {
                    $('#items_id').val(o[0].items_id);
                    $('#items_group').val(o[0].items_group);
                    $('#items_code').val(o[0].items_code);
                    $('#sn_scph').val(o[0].sn_scph);
                    $('#serial_number').val(o[0].serial_number);
                    $('#hardware_id').val(o[0].hardware_id);
                    $('#brand').val(o[0].brand);
                    $('#model').val(o[0].model);
                    $('#items_name').val(o[0].items_name);
                    $('#ipaddress').val(o[0].ipaddress);
                    $('#depart_id').val(o[0].depart_id);
                    $('#buydate').val(o[0].buydate);
                    $('#expdate').val(o[0].expdate);
                    $('#distribute_date').val(o[0].distribute_date);
                    $('#sn_scph').focus();
                    oldItemsGroup = o[0].items_group;
                    oldItemsCode = o[0].items_code;
                }, 'json');

                return false;
            });
        }, 'json');
    }

    $('#btn_reset,#show_dialog').on('click', function() {
        clearForm();
//        return false;
    });

    $('#btn_submit').on('click', function() {
        if ($('#items_id').val() !== "") {
            if (confirm("This data is Editing are you sure!\nEnter OK or Cancel.")) {
                $('#items').attr("action", 'items/xhrEditById');
            } else {
                return false;
                exit();
            }
        } else {
            $('#items').attr("action", 'items/xhrInsert');
        }

        $('#items').submit();
        return false;
    });

//    $('#depart_id,#hardware_id').on('change', function() {
//        $('.cls').empty();
//        callData($('#depart_id').val(), $('#hardware_id').val());
//    });

    $('#items_group').on('change', function() {
        if (oldItemsGroup === $('#items_group').val()) {
            $('#items_code').val(oldItemsCode);
        } else {
            $('#items_code').val('New Code!');
        }
        //callData($('#show_depart_id').val(), $('#show_hardware_id').val(), $('#search').val());
    });

    $('#show_depart_id,#show_hardware_id').on('change', function() {
        $('.cls').empty();
        callData($('#show_depart_id').val(), $('#show_hardware_id').val(), $('#search').val());
    });

    $('#search').on('keyup', function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            $('.cls').empty();
            callData($('#show_depart_id').val(), $('#show_hardware_id').val(), $('#search').val());
        }, delay);
    });

    $("input[name='search_type']").on('change', function() {
        if ($(this).val() === 'choice') {
            $('#div_show_depart_id,#div_show_hardware_id').show();
        } else {
            $('#div_show_depart_id,#div_show_hardware_id').hide();
            $('#show_depart_id,#show_hardware_id').val('0');
        }
        $('.cls').empty();
        callData($('#show_depart_id').val(), $('#show_hardware_id').val(), $('#search').val());
    });

    function clearForm() {
        if ($("input[name='search_type']").val() === 'find') {
            $('#show_depart_id,#show_hardware_id').val('0');
        }
        $('#items_id,#sn_scph,#serial_number,#brand,#model,#items_name,#ipaddress').val('');
        $('#depart_id,#hardware_id').val('');
        $('#div_items_id').hide();//,#div_show_depart_id,#div_show_hardware_id
        $('#buydate').datepicker({
            format: "yyyy-mm-dd",
            language: "th",
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked"
        }).datepicker("setDate", new Date());
        $('#expdate').datepicker({
            format: "yyyy-mm-dd",
            language: "th",
            autoclose: true,
            todayHighlight: true,
            startView: 1,
            todayBtn: "linked"
        }).datepicker("setDate", new Date());
        $('#distribute_date').datepicker({
            format: "yyyy-mm-dd",
            language: "th",
            autoclose: true,
            todayHighlight: true,
            startView: 1,
            todayBtn: "linked"
        }).datepicker("setDate", new Date());
    }

    $("#items").validate({
        rules: {
            sn_scph: {required: true},
            hardware_id: {required: true},
            brand: {required: true},
            model: {required: true},
            depart_id: {required: true},
            buydate: {required: true}
        },
        messages: {
            sn_scph: {required: "Serial is required!"},
            hardware_id: {required: "Hardware is required!"},
            brand: {required: "Brand is required!"},
            model: {required: "Model is required!"},
            depart_id: {required: "Department is required!"},
            buydate: {required: "Buy date is required!"}
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
            var url = $("#items").attr('action');
            var data = $("#items").serialize();
            $.post(url, data, function(o) {
                if (o.sta === 'add') {
                    search = '';
                    depart = $("#depart_id").val();
                    hardware = $("#hardware_id").val();
                } else { // sta = edit or del
                    search = $("#search").val();
                    depart = $("#show_depart_id").val();
                    hardware = $("#show_hardware_id").val();
                    $(".close").click();
                }
                $(".cls").empty();
                clearForm();
                callData(depart, hardware, search);

            }, 'json');

            return false;
        }
    });
});