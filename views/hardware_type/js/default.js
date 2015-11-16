$(function () {
//    make by Shikaru
    clearForm();
    callData();

    function callData(searchtxt) {
        $.get('hardware_type/xhrGetSelect',{'search':searchtxt},function (o) {
            $('#select_data').html('');
            for (var i = 0; i < o.length; i++) {
                $('#select_data').append('<tr class="delTr' + o[i].hardware_type_id + ' cls"><td>' + o[i].hardware_type_id + '</td>'
                        + '<td align="left" style="padding-left:10px">' + o[i].hardware_type_name + '</td>'
                        + '<td>' + o[i].sort + '</td>'
                        + '<td>'
                        + '<a class="edit btn btn-info" rel="' + o[i].hardware_type_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].hardware_type_id + '" data-hardwaretype-name="' + o[i].hardware_type_name + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        + '</td>'
                        + '</tr>'
                        );
            }

            $('.del').on('click', function () {
                /*==============
                 * Delete Button
                 ================*/
                var hardware_type_id = $(this).attr('rel');
                delItem = $('.delTr' + hardware_type_id);

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบรายการงานซ่อม \"" + $(this).attr("data-hardwaretype-name") + "\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {
                    $.post('hardware_type/xhrDeleteById', {'hardware_type_id': hardware_type_id}, function (o) {
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
                /*==============
                 * Edit Button
                 ================*/
                $('#show_dialog').click();
                var hardware_type_id = $(this).attr('rel');

                $.post('hardware_type/xhrSelectByID', {'hardware_type_id': hardware_type_id}, function (o) {
                    $('#hardware_type_id').val(o[0].hardware_type_id);
                    $('#hardware_type_name').val(o[0].hardware_type_name);
                    $('#sort').val(o[0].sort);
                    $('#div_sort').show();
                    $('#hardware_type_name').focus();
                }, 'json');

                return false;
            });
        }, 'json');
    }






    /*==============================
     * Reset Form
     ===============================*/
    function clearForm() {
        $('#hardware_type_id').val("");
        $('#hardware_type_name').val("");
        $('#sort').val("");
        $('#div_sort').hide();
    }

    $('#btn_reset,#show_dialog').on('click', function () {
        alertHide();
        clearForm();
        //return false;
    });



    /*==============================
     * Form validation & Submit
     ===============================*/
//    $('#btn_submit').on('click', function () {
//        if ($('#hardware_type_id').val() !== "") {
//            $('#hardware_type').attr("action", 'hardware_type/xhrEditById');
//        } else {
//            $('#hardware_type').attr("action", 'hardware_type/xhrInsert');
//        }
//
//        $('#hardware_type').submit();
//        return false;
//    });

    $("#hardware_type").validate({
        rules: {
            hardware_type_name: {
                required: true
            }
//            ,
//            keeping: {
//                required: true
//            }
        },
        messages: {
            hardware_type_name: {
                required: "Name is required!"
                        //,minlength: "Field PostCode must contain at least 3 characters"
            }
//            ,
//            password: {
//                required: "Password is required!"
//                        //,minlength: "Field PostCode must contain at least 3 characters"
//            }
        },
        highlight: function (element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function (form) {
            
            if ($('#hardware_type_id').val() !== "") {
                frmMethod2('edit', form);
            } else {
                frmMethod2('insert', form);
                alertInit('success', 'เพิ่มข้อมูลประเภทอุปกรณ์เรียบร้อย');
            }           
            
            var url = $(form).attr('action');
            var data = $(form).serialize();

            $.post(url, data, function () {
                $('.cls').empty();
                callData();
            }, 'json');

            clearForm();
            if ($(form).attr('data-form-method') === 'edit') {
                $('.modal').modal('toggle');
            } else {
                alertShow();
            }

            
            return false;
        }
    });
    

//    $('#hardware_type').on('submit', function () {
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


    /*==============================
     * Search Filter
     ===============================*/
    $('#search').on('keyup', function () {
        $('.cls').empty();
        callData(this.value);
    });



});