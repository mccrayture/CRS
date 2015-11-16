$(function() {
//    checkDivSymName();
    var perPage = 10;
    var visiblePages = 7;
    var delay = 1000; //1 seconds
    var timer;
    
    callData("1");
    alertHide();
    
    /*==============================
     * Data binding
     ===============================*/
    function callData(id,searchtxt) {
        $.post('depart/Pagination', {'id': id, 'search':searchtxt ,'perPage': perPage}, function (o) {
            $('.pagin').empty();
            if (o.allPage > 1) {
                $('.pagin').append('<ul id="pagination" class="pagination-sm"></ul>');
                $('#pagination').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages,
                    onPageClick: function (event, page) {
                        //$('.cls').empty();
                        callGetData(id,searchtxt,page);
                        return false;
                    }
                });
            }
            callGetData(id,searchtxt, 1);
        }, 'json');
    }
    
    function callGetData(id,searchtxt,curPage) {
        if (id === "undefined") {
            id = "1";
        }

        $.get('depart/getListings', {'id': id, 'search':searchtxt,'perPage': perPage, 'curPage': curPage}, function (o) {
            var strTable = "";
            var color = "";
            var id = 0;
            $('#listings').html('');
          
            strTable += '<table class = "table"> \n\
                        <thead> \n\
                        <tr> \n\
                        <th> ID </th>  \n\
                        <th> NAME </th>     \n\
                        <th> Tel. </th>    \n\
                        <th> Status </th>    \n\
                        <th> MANAGE </th>   \n\
                        </tr>   \n\
                        </thead>    \n\
                        <tbody> ';

            for (var i = 0; i < o.length; i++) {
                id = i + 1;
                if ((i % 2) === 1) {
                    color = 'info';
                } else {
                    color = '';
                }
                if (o[i].depart_status === '0') {
                    danger = 'danger';
                } else {
                    danger = '';
                }

                strTable += '<tr class="' + color + ' ' + danger + '">';
                strTable += '<td>' + id + '</td>';
                strTable += '<td>' + o[i].depart_name + '</td>';
                strTable += '<td>' + o[i].depart_tel + '</td>';
                strTable += '<td>' + o[i].depart_status_name + '</td>';
                strTable += '<td style="text-align:right;">'
                        + '<a class="edit btn btn-info" rel="' + o[i].depart_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].depart_id + '" data-depart-name="'+o[i].depart_name+'" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>'
                        + '</td>';
                strTable += '</tr>';
            }

            strTable += '</tbody>\n\
                    </table>';
            $('#listings').append(strTable);         

        }, 'json');

    }
    
    /* Edit and Delete Button */
    $('#listings')
            .on('click', ".edit", function () {
                $('#show_dialog').click();
                $('#div_depart_id').show();
                editItem = $(this);
                var id = $(this).attr('rel');

                $.post('depart/getByID', {'id': id}, function (o) {
                    $('#depart_id').val(o[0].depart_id);
                    $('#depart_name').val(o[0].depart_name);
                    $('#depart_status').val(o[0].depart_status);
                    if(o[0].depart_status > 0){
                        $('#depart_status').prop("checked",true);                        
                    }else{$('#depart_status').prop("checked",false);}
                    
                    $('#depart_status_name').val(o[0].depart_status_name);
                    $('#depart_tel').val(o[0].depart_tel);
                    $('#depart_name').focus();
//                    $('#div_depart_tel').show();
                }, 'json');


                return false;
                
            })
            .on('click', ".del", function () {
                $('#div_depart_id').hide();
                delItem = $(this);
                var id = $(this).attr('rel');

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบหน่วยงาน \"" + $(this).attr("data-depart-name") + "\" หรือไม่ ?");
                delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {
                    $.post('depart/deleteByID', {'id': id}, function (o) {
                        if (o.chk) {
                            delItem.empty();
                        } else {
                            alertDialog.realize();
                            alertDialog.setMessage("ลบข้อมูลไม่สำเร็จ!\nข้อมูลนี้ถูกใช้งานแล้ว ไม่สามารถลบออกได้");
                            alertDialog.open();
                        }
                        callData($('#item_type_id_Filter').val());
                        delConfirmDialog.close();
                    }, 'json'); // not use return json data
                });
                delConfirmDialog.open();
                return false;
            });

    /*==============================
     * Reset Form
     ===============================*/
    function clearEditForm() {
        $('#depart_id').val("");
        $('#depart_name').val("");
        $('#depart_status').val("1").prop("checked",true);
        $('#depart_tel').val("");
        $('#div_depart_id').hide();
//        $('#div_depart_tel').hide();

        /* Clear validate */
        validator.resetForm(); //clear validate
        $("#editForm .form-group").removeClass('has-error');
        $("#editForm .glyphicon").removeClass('glyphicon-remove');
    }

    $('#btn_reset,#show_dialog').on('click', function () {
        alertHide();
        clearEditForm();
//        return false;
    });
    
    /*==============================
     * Form validation & Submit
     ===============================*/
    var validator = $("#editForm").validate({
        rules: {
            depart_name: {required: true},
        },
        messages: {
            hardware_name: {required: "ชื่อหน่วยงาน ห้ามเป็นค่าว่าง"},
        },
        highlight: function (element) {
            var fbk = "#" + $(element).attr("id") + "-fbk";

            $(element).closest('.form-group').addClass('has-feedback has-error');
            if ($(fbk).length) {
                $(fbk).addClass('glyphicon-remove');
            } else {
                $('<span class="glyphicon glyphicon-remove form-control-feedback" id="' + fbk.substr(1) + '"></span>').insertAfter(element);
            }

        },
        unhighlight: function (element) {
            var fbk = "#" + $(element).attr("id") + "-fbk";
            $(element).closest('.form-group').removeClass('has-error');
            $(fbk).removeClass('glyphicon-remove');
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
            if ($('#depart_id').val() !== "") {
                frmMethod('edit', form);
            } else {
                frmMethod('insert', form);
                alertInit('success', 'เพิ่มข้อมูลอุปกรณ์เรียบร้อย');
            }

            var url = $(form).attr('action');
            var data = $(form).serialize();
            if ($('#depart_status').prop("checked") === true) {
                data += "&depart_status_value=1";
            } else {
                data += "&depart_status_value=0";
            }
            
            
            $.post(url, data, function (o) {
                callData($('#hardware_type_id').val());
            });

            clearEditForm();
            if ($(form).attr('data-form-method') === 'edit') {
                $('.modal').modal('toggle');
            } else {
                alertShow();
            }

            return false;

        }
    });
    
    
    
    /* Form method setting */
    function frmMethod(method, form) {
        var methodname = typeof method === 'undefined' ? 'insert' : method.toLowerCase();
        var formname = typeof form === 'undefined' ? $("form").get(0) : form;

        var meth;
        switch (methodname) {
            case 'insert':
                meth = 'insertByID';
                break;
            case 'edit':
                meth = 'editByID';
                break;
        }

        $(formname).attr({
            "action": document.URL + "/" + meth
            , "data-form-method": methodname
        });
    }
//    function checkDivSymName() {
//        if ($('#depart_name').val() === '') {
//            $('#div_depart_tel').hide();
//        } else {
//            $('#div_depart_tel-group').show();
//        }
//    }


    /*==============================
     * Search Filter
     ===============================*/
    $('#search').on('keyup', function () {
        clearTimeout(timer);
        timer = setTimeout(function() {
        
        $('.cls').empty();
        callData($('#depart_id').val(), $('#search').val());
        }, delay);
    });

});

