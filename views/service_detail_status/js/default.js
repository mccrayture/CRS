$(function() {
//    make by Shikaru 
    clearForm();
    callData();

    function callData() {
        $.get('service_detail_status/xhrGetSelect', function(o) {
            for (var i = 0; i < o.length; i++) {
                $('#select_data').append('<tr class="delTr' + o[i].status_id + ' cls"><td>' + o[i].status_id + '</td>'
                        + '<td align="left" style="padding-left:10px">' + o[i].status_name + '</td>'
                        + '<td style="background-color:' + o[i].status_color + ';"></td>'
                        + '<td align="center">' + o[i].sort + '</td>'
                        + '<td>'
                        + '<a class="edit btn btn-info" rel="' + o[i].status_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].status_id + '" data-status-name="' + o[i].status_name + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        + '</td>'
                        + '</tr>'
                        );
            }

            $('.del').on('click', function() {
                var status_id = $(this).attr('rel');
                delItem = $('.delTr' + status_id);

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบสถานะการซ่อม \"" + $(this).attr("data-status-name") + "\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {
                    $.post('service_detail_status/xhrDeleteById', {'status_id': status_id}, function(o) {
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
                var status_id = $(this).attr('rel');

                $.post('service_detail_status/xhrSelectByID', {'status_id': status_id}, function(o) {
                    $('#status_id').val(o[0].status_id);
                    $('#status_name').val(o[0].status_name);
                    $('#status_color').val(o[0].status_color);
                    $('#sort').val(o[0].sort);
                    $('#div_sort').show();
                    $('#status_name').focus();
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
        if ($('#status_id').val() !== "") {
            $('#service_detail_status').attr("action", 'service_detail_status/xhrEditById');
        } else {
            $('#service_detail_status').attr("action", 'service_detail_status/xhrInsert');
        }

        $('#service_detail_status').submit();
        return false;
    });

    function clearForm() {
        $('#status_id').val("");
        $('#status_name').val("");
        $('#status_color').val("");
        $('#sort').val("");
        $('#div_sort').hide();
    }

    $("#service_detail_status").validate({
        rules: {
            status_name: {required: true},
            status_color: {required: true}
//            ,
//            keeping: {
//                required: true
//            }
        },
        messages: {
            status_name: {required: "Name is required!"},
            status_color: {required: "Name is required!"}
            //,minlength: "Field PostCode must contain at least 3 characters"
//            ,
//            password: {
//                required: "Password is required!"
//                        //,minlength: "Field PostCode must contain at least 3 characters"
//            }
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
            var url = $("#service_detail_status").attr('action');
            var data = $("#service_detail_status").serialize();

            $.post(url, data, function() {
                $('.cls').empty();
                callData();
            }, 'json');

            clearForm();
            return false;
        }
    });

//    $('#service_status').on('submit', function () {
//        var url = $(this).attr('action');
//        var data = $(this).serialize();
//
//        $.post(url, data, function () {
//            $('.cls').empty();
//            callData();
//        }, 'json');
//
//        clearForm();
//        return false;
//    });
});