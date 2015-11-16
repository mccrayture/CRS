$(function() {
    checkDivHWName();
    perPage = 10;
    visiblePages = 7;
    callData("1");
    alertHide();
    
    /*==============================
     * Data binding
     ===============================*/
    function callData(id) {
        $.post('hardware/Pagination', {'id': id, 'perPage': perPage}, function (o) {
            $('.pagin').empty();
            if (o.allPage > 1) {
                $('.pagin').append('<ul id="pagination" class="pagination-sm"></ul>');
                $('#pagination').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages,
                    onPageClick: function (event, page) {
                        //$('.cls').empty();
                        callGetData(id, page);
                        return false;
                    }
                });
            }
            callGetData(id, 1);
        }, 'json');
    }
    function callGetData(id,curPage) {
        if (id === "undefined") {
            id = "1";
        }

        $.get('hardware/getListings', {'id': id, 'perPage': perPage, 'curPage': curPage}, function (o) {
            var strTable = "";
            var color = "";
            var id = 0;
            $('#listings').html('');

            strTable += '<table class = "table"> \n\
                        <thead> \n\
                        <tr> \n\
                        <th class="col-md-2"> ID </th>  \n\
                        <th class="col-md-4"> NAME </th>     \n\
                        <th class="col-md-2"> GROUP </th>    \n\
                        <th class="col-md-2"> SORT </th>     \n\
                        <th class="col-md-2"> MANAGE </th>   \n\
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

                strTable += '<tr class="' + color + '">';
                strTable += '<td>' + id + '</td>';
                strTable += '<td>' + o[i].hardware_name + '</td>';
                strTable += '<td>' + o[i].hardware_group_id + '</td>';
                strTable += '<td>' + o[i].hardware_sort + '</td>';
                strTable += '<td>'
                        + '<a class="edit btn btn-info" rel="' + o[i].hardware_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].hardware_id + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
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
                $('#div_hardware_id').show();
                editItem = $(this);
                var id = $(this).attr('rel');

                $.post('hardware/getByID', {'id': id}, function (o) {
                    $('#hardware_id').val(o[0].hardware_id);
                    $('#hardware_name').val(o[0].hardware_name);
                    $('#hardware_type_id').val(o[0].hardware_type_id);
                    $('#hardware_sort').val(o[0].hardware_sort);
                    $('#div_hardware_sort').show();
                    $('#hardware_name').focus();
                }, 'json');


                return false;
            })
            .on('click', ".del", function () {
                $('#div_hardware_id').hide();
                delItem = $(this);
                var id = $(this).attr('rel');
                
                delConfirmDialog.realize();
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function(){
                    $.post('hardware/deleteByID', {'id': id}, function (o) {
                        if (o.chk){
                            delItem.empty();
                        } else {
                            alertDialog.setMessage('Primary Key is already use. Cannot Delete !!!.');
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
        $('#hardware_id').val("");
        $('#hardware_name').val("");
        $('#hardware_type_id').val("1");
        $('#hardware_sort').val("Max Sort");
        $('#div_hardware_sort').hide();
        $('#div_hardware_id').hide();
        /* Clear validate */
        validator.resetForm(); //clear validate
        $("#editForm .form-group").removeClass('has-error');
        $("#editForm .glyphicon").removeClass('glyphicon-remove');

    }

    $('#btn_reset,#show_dialog').on('click', function() {
        alertHide();
        clearEditForm();
        //return false;
    });

    /*==============================
     * Form validation & Submit
     ===============================*/
   
    var validator = $("#editForm").validate({
        rules: {
            hardware_name: {required:true}
        },
        messages: {
            hardware_name: {required: "Data is required!"},
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
        submitHandler: function(form) {
            if ($('#hardware_id').val() !== "") {
                frmMethod('edit',form);
            } else {
                frmMethod('insert',form);
                alertInit('success','เพิ่มข้อมูลอุปกรณ์เรียบร้อย');
            }            
            
            var url = $(form).attr('action');
            var data = $(form).serialize();
            $.post(url, data, function(o){
                callData($('#hardware_type_id').val());
            });
            
            clearEditForm();
            if($(form).attr('data-form-method')==='edit'){$('.modal').modal('toggle');}else{alertShow();}
           
            return false;
            
        }
    });
    
    function checkDivHWName() {
        if ($('#hardware_name').val() === '') {
            $('#div_hardware_sort').hide();
        } else {
            $('#div_hardware_sort-group').show();
        }
    } 
    
    /* Form method setting */
    function frmMethod(method,form){
        var methodname = typeof method === 'undefined' ? 'insert' : method.toLowerCase() ;
        var formname = typeof form === 'undefined' ? $("form").get(0) : form ;
        
        var meth;
        switch(methodname){
            case 'insert': meth = 'insertByID'; break;
            case 'edit': meth = 'editByID'; break;
        }
        
        $(formname).attr({
            "action": document.URL + "/" + meth
            ,"data-form-method" : methodname
        });
    }
    /*==============================
     * Alert box
     ===============================*/
    /* Create alert for show above Form */
    function alertInit(alertType,alertTxt){
        alertTxt = (typeof alertTxt === 'undefined') ? '...' : alertTxt;
        $("#formAlert").html(''); //clear
        
        var txtAlert = '<div class="alert alert-dismissible" role="alert" >'+
                        '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'+
                        '<span aria-hidden="true">&times;</span>'+
                        '</button>'+
                        '<span class="txtAlert"></span>'+
                        '</div>';
        $("#formAlert").html(txtAlert);
        
        if(alertType==='success'){$("#formAlert .alert").addClass("alert-success");}
        else if(alertType==='warning'){$("#formAlert .alert").addClass("alert-warning");}
        else if(alertType==='info'){$("#formAlert .alert").addClass("alert-info");}
        else if(alertType==='danger'){$("#formAlert .alert").addClass("alert-danger");}
        
        $("#formAlert span.txtAlert").html(alertTxt);
        
    }
    function alertShow(){$("#formAlert").show();}            
    function alertHide(){$("#formAlert").hide();}

    /*==============================
     * Search Filter
     ===============================*/
    $('#item_type_id_Filter').on('change', function() {
        callData($('#item_type_id_Filter').val());

    });
    
});

