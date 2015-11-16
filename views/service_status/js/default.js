$(function () {
//    make by Shikaru 
    clearForm();
    callData();

    function callData() {
        $.get('service_status/xhrGetSelect', function (o) {
            for (var i = 0; i < o.length; i++) {
                $('#select_data').append('<tr class="delTr' + o[i].service_status_id + ' cls">'
                        + '<td class="col-md-1">' + o[i].service_status_id + '</td>'
                        + '<td class="col-md-8" align="left" style="padding-left:10px">' + o[i].service_status_name + '</td>'
                        + '<td class="col-md-1">' + o[i].sort + '</td>'
                        + '<td class="col-md-2">'
                        + '<a class="edit btn btn-info" rel="' + o[i].service_status_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].service_status_id + '" data-servicestatus-name="' + o[i].service_status_name + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        + '</td>'
                        + '</tr>'
                        );
            }

            $('.del').on('click', function () {
                var service_status_id = $(this).attr('rel');
                delItem = $('.delTr' + service_status_id);

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบการดำเนินการ \"" + $(this).attr("data-servicestatus-name") + "\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {
                    $.post('service_status/xhrDeleteById', {'service_status_id': service_status_id}, function (o) {
                        if (o.chk) {
                            delItem.empty();
                        } else {
                            alertDialog.setMessage('Primary Key is already use. Cannot Delete !!!.');
                            alertDialog.open();
                        }
                        callData();
                        delConfirmDialog.close();
                    }, 'json'); // not use return json data
                });
                delConfirmDialog.open();
                return false;
            });

            $('.edit').on('click', function () {
                var service_status_id = $(this).attr('rel');

                $.post('service_status/xhrSelectByID', {'service_status_id': service_status_id}, function (o) {
                    $('#service_status_id').val(o[0].service_status_id);
                    $('#service_status_name').val(o[0].service_status_name);
                    $('#sort').val(o[0].sort);
                    $('#div_sort').show();
                    $('#service_status_name').focus();
                }, 'json');

                return false;
            });
        }, 'json');
    }

    $('#btn_reset').on('click', function () {
        clearForm();
        return false;
    });

    $('#btn_submit').on('click', function () {
        if ($('#service_status_id').val() !== "") {
            $('#service_status').attr("action", 'service_status/xhrEditById');
        } else {
            $('#service_status').attr("action", 'service_status/xhrInsert');
        }

        $('#service_status').submit();
        return false;
    });

    /*==============================
     * Reset Form
     ===============================*/
    function clearForm() {
        $('#service_status_id').val("");
        $('#service_status_name').val("");
        $('#sort').val("");
        $('#div_sort').hide();
    }


    /*==============================
     * Form validation & Submit
     ===============================*/
    $("#service_status").validate({
        rules: {
            service_status_name: {
                required: true
            }
//            ,
//            keeping: {
//                required: true
//            }
        },
        messages: {
            service_status_name: {
                required: "Name is required!"
                        //,minlength: "Field PostCode must contain at least 3 characters"
            }
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
            var url = $("#service_status").attr('action');
            var data = $("#service_status").serialize();

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