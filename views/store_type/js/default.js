$(function() {
//    make by Shikaru
    clearForm();
    callData();

    function callData() {
        $.get('store_type/xhrGetSelect', function(o) {
            for (var i = 0; i < o.length; i++) {
                $('#select_data').append('<tr class="delTr' + o[i].store_type_id + ' cls"><td>' + o[i].store_type_sort + '</td>'
                        + '<td align="left" style="padding-left:10px">' + o[i].store_type_name + '</td>'
                        + '<td align="left" style="padding-left:10px">' + o[i].store_type_keeping + '</td>'
                        + '<td align="left" style="padding-left:10px">' + o[i].store_type_count + '</td>'
                        + '<td>'
                        + '<a class="edit btn btn-info" rel="' + o[i].store_type_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].store_type_id + '" data-storetype-name="' + o[i].store_type_name + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        + '</td>'
                        + '</tr>'
                        );
            }

            $('.del').on('click', function() {
                var store_type_id = $(this).attr('rel');
                delItem = $('.delTr' + store_type_id);

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบประเภทอะไหล่ \""+$(this).attr("data-storetype-name")+"\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {
                    $.post('store_type/xhrDeleteById', {'store_type_id': store_type_id}, function (o) {
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
                var store_type_id = $(this).attr('rel');

                $.post('store_type/xhrSelectByID', {'store_type_id': store_type_id}, function(o) {
                    $('#store_type_id').val(o[0].store_type_id);
                    $('#store_type_name').val(o[0].store_type_name);
                    if (o[0].store_type_keeping === 'serial') {
                        $("#keeping_1").prop("checked", true);
                    } else {
                        $("#keeping_2").prop("checked", true);
                    }
                    $('#store_type_count').val(o[0].store_type_count);
                    $('#store_type_sort').val(o[0].store_type_sort);
                    $('#div_sort').show();
                    $('#store_type_name').focus();
                }, 'json');

                return false;
            });
        }, 'json');
    }

    $('#btn_reset').on('click', function() {
        clearForm();
        return false;
    });

    $('#btn_submit').on('click', function() {


        if ($('#store_type_id').val() !== "") {
            $('#store_type').attr("action", 'store_type/xhrEditById');
        } else {
            $('#store_type').attr("action", 'store_type/xhrInsert');
        }

        $('#store_type').submit();
        return false;
    });

    function clearForm() {
        $('#store_type_id').val("");
        $('#store_type_name').val("");
        $('#keeping_1').prop("checked", true);
        $('#store_type_count').val("");
        $('#store_type_name').val("");
        $('#div_sort').hide();
    }

    $("#store_type").validate({
        rules: {
            store_type_name: {required: true}
//            ,keeping: {required: true}
        },
        messages: {
            store_type_name: {required: "Name is required!"}
//            ,password: {required: "Password is required!"}
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
            var url = $("#store_type").attr('action');
            var data = $("#store_type").serialize();

            $.post(url, data, function() {
                $('.cls').empty();
                callData();
            }, 'json');

            clearForm();
            return false;
        }
    });

//    $('#store_type').on('submit', function() {
//        var url = $(this).attr('action');
//        var data = $(this).serialize();
//
//        $.post(url, data, function() {
//            $('.cls').empty();
//            callData();
//        }, 'json');
//
//        clearForm();
//        return false;
//    });
});