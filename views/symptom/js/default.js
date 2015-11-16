$(function() {

//    var totalData = 0; //collect data's record count
    var symptom_id = "1";
    perPage = 10;
    visiblePages = 7;
    checkDivSymName();
    callData(symptom_id);
    
    /*==============================
     * Data binding
     ===============================*/        
    function callData(id) {
        $.post('symptom/Pagination', {'id': id, 'perPage': perPage}, function (o) {
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
        
    function callGetData(id, curPage){
        if (id === "undefined") {
            id = "1";
        }
//        if (typeof limitData === "undefined") {
//            limitData = {'limit': 10, 'limitStart': 0};
//        }

        $.get('symptom/getListings', {'id': id, 'perPage': perPage, 'curPage': curPage}, function (o) {
            var strTable = "";
            var color = "";
            var id = 0;
            $('#listings').html('');

            strTable += '<table class = "table table-striped"> \n\
                        <thead> \n\
                        <tr> \n\
                        <th class="col-md-2"> ID </th>  \n\
                        <th class="col-md-5"> NAME </th>     \n\
                        <th class="col-md-2"> SORT </th>    \n\
                        <th class="col-md-3"> MANAGE </th>   \n\
                        </tr>   \n\
                        </thead>    \n\
                        <tbody> ';

            for (var i = 0; i < o.length; i++) {
                id = i + 1;
                /*if ((i % 2) === 1) {
                    color = 'info';
                } else {
                    color = '';
                }*/

                strTable += '<tr class="' + color + '">';
                strTable += '<td>' + id + '</td>';
                strTable += '<td>' + o[i].sym_name + '</td>';
                strTable += '<td>' + o[i].sym_sort + '</td>';
                strTable += '<td>'
                        +'<a class="edit btn btn-info" rel="' + o[i].sym_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Edit</a>'
                        +' '
                        +'<a class="del btn btn-danger" rel="' + o[i].sym_id + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> Delete</a>'
                        +'</td>';
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
                $('#div_sym_id').show();
                editItem = $(this);
                var id = $(this).attr('rel');

                $.post('symptom/getByID', {'id': id}, function (o) {
                    $('#sym_id').val(o[0].sym_id);
                    $('#sym_name').val(o[0].sym_name);
                    $('#hardware_type_id').val(o[0].hardware_type_id);
                    $('#sym_sort').val(o[0].sym_sort);
                    $('#div_sym_sort').show();
                    $('#sym_name').focus();
                }, 'json');
                return false;
            })
            .on('click', ".del", function () {
                $('#div_sym_id').hide();
                delItem = $(this);
                var id = $(this).attr('rel');

                delConfirmDialog.realize();
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {
                    $.post('symptom/deleteByID', {'id': id}, function (o) {
                        if (o.chk) {
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
        $('#sym_id').val("");
        $('#sym_name').val("");
        $('#hardware_type_id').val("1");
        $('#sym_sort').val("");
        $('#div_sym_sort').hide();
        $('#div_sym_id').hide();
        
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
            sym_name: {required: true}
        },
        messages: {
            sym_name: {required: "Data is required!"},
        },
        highlight: function(element){
            var fbk = "#" + $(element).attr("id") + "-fbk";
            
            $(element).closest('.form-group').addClass('has-feedback has-error');
            if ($(fbk).length) {
                $(fbk).addClass('glyphicon-remove');
            } else {
                $('<span class="glyphicon glyphicon-remove form-control-feedback" id="'+fbk.substr(1)+'"></span>').insertAfter(element);
            }
                   
        },
        unhighlight: function(element){
            var fbk = "#" + $(element).attr("id") + "-fbk";            
            $(element).closest('.form-group').removeClass('has-error');
            $(fbk).removeClass('glyphicon-remove');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error,element){
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form){
            
            if ($('#sym_id').val() !== "") {
                frmMethod('edit', form);
            } else {
                frmMethod('insert', form);
                alertInit('success', 'เพิ่มข้อมูลอาการเสียเรียบร้อย');
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
    
    function checkDivSymName() {
        if ($('#sym_name').val() === '') {
            $('#div_sym_sort').hide();
        } else {
            $('#div_sym_sort-group').show();
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
        var symptom_select_id = $('#item_type_id_Filter').val();

        callData(symptom_select_id);

    });
});