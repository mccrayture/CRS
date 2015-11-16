$(function() {

//    var totalData = 0; //collect data's record count
    var default_jobs_group_id = "99";
    //cur_page = 1;
    perPage = 10;
    visiblePages = 7;
    var jobs_group_id = '';
    checkDivJobsName();
    callData(default_jobs_group_id);
    
    /*==============================
     * Data binding
     ===============================*/        
    function callData(id) {
        $.post('jobs/Pagination', {'jobs_group_id': id, 'perPage': perPage}, function (o) {
            $('.pagin').empty();
            if (o.allPage > 1) {
                $('.pagin').append('<ul id="pagination" class="pagination-sm"></ul>');
                $('#pagination').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages,
                    //startPage : cur_page,
                    onPageClick: function (event, page) {
                        //$('.cls').empty();
                        //cur_page = page;
                        callGetData(id, page);
                        return false;
                    }
                });
            }
            //else{cur_page = 1;}
            callGetData(id, 1);
        }, 'json');
    }
        
    function callGetData(id, curPage){
        if (id === "undefined") {id = "1";}
        
        $.get('jobs/getListings', {'id': id, 'perPage': perPage, 'curPage': curPage}, function (o) {
            var strTable = "";
            var color = "";
            var id = 0;
            $('#listings').html('');

            strTable += '<table class = "table table-striped"> \n\
                        <thead> \n\
                        <tr> \n\
                        <th> ID </th>  \n\
                        <th> NAME </th>     \n\
                        <th> UNIT PRICE </th>    \n\
                        <th> GROUP </th>    \n\
                        <th> SORT </th>   \n\
                        <th> STATUS </th>   \n\
                        <th> MANAGE </th>   \n\
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
                strTable += '<td>' + o[i].jobs_name + '</td>';
                strTable += '<td>' + addCommas(o[i].jobs_unit_price) + '</td>';
                strTable += '<td>' + o[i].jobs_group_name + '</td>';
                strTable += '<td>' + o[i].sort + '</td>';
                strTable += '<td>' + o[i].jobs_status + '</td>';
                strTable += '<td>'
                        //+'<div class="btn-group">'
                        +'<a class="edit btn btn-info" rel="' + o[i].jobs_id + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        +' '
                        +'<a class="del btn btn-danger" rel="' + o[i].jobs_id + '" data-job-name="'+o[i].jobs_name+'" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        //+'</div>';
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
            /*==============
             * Edit Button
             ================*/ 
            .on('click', ".edit", function () {
                $('#show_dialog').click();
                $('#div_jobs_id').show();
                editItem = $(this);
                var id = $(this).attr('rel');

                $.post('jobs/getByID', {'id': id}, function (o) {
                    $('#jobs_id').val(o[0].jobs_id);
                    $('#jobs_name').val(o[0].jobs_name);
                    $('#jobs_unit_price').val(o[0].jobs_unit_price);
                    $('#jobs_group').val(o[0].jobs_group);
                    $('#jobs_sort').val(o[0].sort);
                    
                    $('#div_jobs_sort').show();
                    $('#jobs_name').focus();
                }, 'json');
                
                return false;
            })
            .on('click', ".del", function () {
                /*==============
                 * Delete Button
                 ================*/ 
                
                $('#div_jobs_id').hide();
                delItem = $(this);
                var id = $(this).attr('rel');

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบรายการงานซ่อม \""+$(this).attr("data-job-name")+"\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function () {
                    $.post('jobs/deleteByID', {'id': id}, function (o) {
                        if (o.chk) {
                            delItem.empty();
                        } else {
                            alertDialog.setMessage('Primary Key is already use. Cannot Delete !!!.');
                            alertDialog.open();
                        }
                        callData($('#jobs_group_id_Filter').val());
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
        $('#jobs_id').val("");
        $('#jobs_name').val("");
        $('#jobs_unit_price').val("");
        $('#jobs_group').val("1");
        $('#jobs_sort').val("");
        
        //hiding id and sortable id
        $('#div_jobs_sort').hide();
        $('#div_jobs_id').hide();
        
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
            jobs_name: {required: true},
            jobs_unit_price: {required: true,/*number: true,min: 0*/}
        },
        messages: {
            jobs_name: {required: "job's name is required!"},
            jobs_unit_price: {required: "job's unit price is required!"},
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
            
            if ($('#jobs_id').val() !== "") {
                frmMethod1('edit', form);
                
            } else {
                frmMethod1('insert', form);
                alertInit('success', 'เพิ่มข้อมูลงานซ่อมเรียบร้อย');
                
            }
            
            var url = $(form).attr('action');
            var data = $(form).serialize();
            $.post(url, data, function(o){
                console.log(o.chk);
                callData($('#jobs_group_id_Filter').val());

            });

            clearEditForm();
            if($(form).attr('data-form-method')==='edit'){$('.modal').modal('toggle');}else{alertShow();}

            return false;

        }
    });
    
    
    function checkDivJobsName() {
        if ($('#jobs_name').val() === '') {
            $('#div_jobs_sort').hide();
        } else {
            $('#div_jobs_sort').show();
        }
    }
    
    /*==============================
     * Bootstrap modal event
     ===============================*/
    $('#frm-new-jobs').on('shown.bs.modal', function () {
        $('#jobs_name').focus();
    });
        
        
    /*==============================
     * Search Filter
     ===============================*/
    $('#jobs_group_id_Filter').on('change', function() {
        callData($('#jobs_group_id_Filter').val());

    });
});