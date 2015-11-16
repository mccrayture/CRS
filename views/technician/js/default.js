$(function() {

    checkDivTechStatus();
    callData("1");
    perPage_Person = 5;
    visiblePages_Person = 5;

    /*==============================
     * Data binding
     ===============================*/
    function callData(id) {
        if (id === "undefined") {
            id = "1";
        }
        $.get('technician/getListings', {'id': id}, function(o) {
            var strTable = "";
            var color = "";
            console.log(o);
            $('#listings').html('');

            strTable += '<table class = "table table-striped table-bordered table-condensed"> \n\
                        <thead> \n\
                        <tr> \n\
                        <th> CID </th>  \n\
                        <th> NAME </th>     \n\
                        <th> STATUS </th>    \n\
                        <th> MANAGE </th>   \n\
                        </tr>   \n\
                        </thead>    \n\
                        <tbody> ';

            for (var i = 0; i < o.length; i++) {
//                alert(i);

                strTable += '<tr>';
                strTable += '<td>' + o[i].technician_cid + '</td>';
                strTable += '<td>' + (o[i].prefix + o[i].firstname + ' ' + o[i].lastname) + '</td>';
                strTable += '<td>' + (o[i].technician_status === '1' ? '<span class="label label-success">ใช้งาน</span>' : '<span class="label label-danger">ไม่ใช้</span>') + '</td>';
//                strTable += '<td> <a class="edit" rel="' + o[i].technician_cid + '" href="#">Edit</a></td>';
//                strTable += '<td> <a class="del" rel="' + o[i].technician_cid + '" href="#">Delete</a></td>';
                strTable += '<td>'
                        //+'<div class="btn-group">'
                        + '<a class="edit btn btn-info" rel="' + o[i].technician_cid + '" href="#" ><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                        + ' '
                        + '<a class="del btn btn-danger" rel="' + o[i].technician_cid + '" data-technician-name="' + (o[i].prefix + o[i].firstname + ' ' + o[i].lastname) + '" href="#" ><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                        //+'</div>';
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
            .on('click', ".edit", function() {
                $('#show_dialog').click();
                editItem = $(this);
                var id = $(this).attr('rel');

                $.post('technician/getByID', {'id': id}, function(o) {
                    $('#technician_cid').val(o[0].technician_cid);
                    $('#tech_name').val(o[0].prefix + o[0].firstname + ' ' + o[0].lastname);

                    if (o[0].status === '1') {
                        $('#tech_status').prop("checked", true)
                    }
                    else {
                        $('#tech_status').prop("checked", false)
                    }

                    $('#tech_status').val(o[0].status);
                    $('#div_tech_status').show();
                    $('#technician_cid').focus();



                }, 'json');
                return false;
            })
            .on('click', ".del", function() {
                delItem = $(this);
                var id = $(this).attr('rel');

                delConfirmDialog.realize();
                delConfirmDialog.setMessage("ต้องการลบเจ้าหน้าที่เทคนิค \"" + $(this).attr("data-technician-name") + "\" หรือไม่ ?");
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function() {
                    $.post('technician/deleteByID', {'id': id}, function(o) {
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


    $('#item_type_id_Filter').on('change', function() {
        callData($('#item_type_id_Filter').val());
    });


    $('#div_tech_cid').bind('keypress', function(e) {
        if (e.which === 32) {//space bar
            $('.modal').modal('show');
        }
        clearEditForm();
    });

//    function centerModal() {
//    $(this).css('display', 'block');
//    var $dialog = $(this).find(".modal-dialog");
//    var offset = ($(window).height() - $dialog.height()) / 2;
//    // Center modal vertically in window
//    $dialog.css("margin-top", offset);
//}
//
//    $('.modal').on('show.bs.modal', centerModal);
//    $(window).on("resize", function () {
//        $('.modal:visible').each(centerModal);
//    });

    $('#btn_submit').on('click', function() {
        var tech_cid = $("#technician_cid").val();
        var tech_name = $("#tech_name").val();

        if (tech_cid !== "" && tech_name !== "") {
            $('#editForm').attr("action", "technician/updateTecnician");
            $('#editForm').submit();

        } else {
            alertInit('danger', 'ผิดพลาด! ไม่สามารถเพิ่มหรือแก้ไขข้อมูลได้');
            alertShow();
        }
        return false;
    });

    $('#editForm').submit(function() {
        var url = $(this).attr('action');
        var data = $(this).serialize();
        alertInit('success', 'เพิ่มข้อมูลเจ้าหน้าที่เทคนิคเรียบร้อย');

        $.post(url, data, function() {
            //callData($('#technician_cid').val());
            callData($('#technician_cid').val());
        });

        clearEditForm();
        return false;
    });

    function callDataPerson(search) {
        $.post('technician/Pagination', {'search': search, 'perPage': perPage_Person}, function(o) {
            $('.pagin-person').empty();
            if (o.allPage > 1) {
                $('.pagin-person').append('<ul id="pagination-person" class="pagination-sm"></ul>');
                $('#pagination-person').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages_Person,
                    onPageClick: function(event, page) {
                        $('.cls-person').empty();
                        callGetPersonData(search, page);
                        return false;
                    }
                });
            }
            callGetPersonData(search, 1);
        }, 'json');
    }

    function callGetPersonData(search, curPage) {
        $.get('technician/getPerson', {'search': search, 'perPage': perPage_Person, 'curPage': curPage}, function(o) {
            for (var i = 0; i < o.length; i++) {
                if (o[i].expire === '1') {
                    danger = 'warning';
                } else {
                    danger = '';
                }
                $('#select_person_data').append('<tr class="cls-person ' + danger + '"><td>' + o[i].person_id + '</td>'
                        + '<td>' + o[i].pname + o[i].fname + ' ' + o[i].lname + '</td>'
                        + '<td>' + o[i].office + '</td>'
                        + '<td align="center"><a class="choose-person" rel="' + o[i].person_id + '" data-person_name="' + o[i].pname + o[i].fname + ' ' + o[i].lname + '" href="#">Choose</a></td>'
                        + '</tr>'
                        );
            }

            $('.choose-person').on('click', function() {
                $('#technician_cid').val($(this).attr('rel'));
                $('#tech_name').val($(this).attr('data-person_name'));
//                $('.modal').modal('hide');
                $('.frm-choose-person').modal('hide');
            });
        }, 'json');
    }

    $('#choose-person').on('click', function() {
        $('.cls-person').empty();
        callDataPerson('');
    });

    $('#choose_search_person').on('keyup', function() {
        $('.cls-person').empty();
        callDataPerson(this.value);
    });

    $('#btn_reset,#show_dialog').on('click', function() {
        alertHide();
        clearEditForm();
        $('#tech_status').val('1');//.checkboxX("refresh") if jMobile
        //return false;
    });

    $("#tech_status").on("change", function() {
        if ($(this).prop("checked") === true) {
            $(this).val(1);
        }
        else {
            $(this).val(0);
        }
    });


    /*==============================
     * Reset Form
     ===============================*/
    function clearEditForm() {
        $('#technician_cid').val("");
        $('#tech_name').val("");
        $('#technician_username').val("");
        $('#technician_password').val("");
        $('#tech_status').val(1);
//        $('#div_tech_status').hide();
    }

    function checkDivTechStatus() {
        if ($('#tech_status').val() === '') {
            $('#div_tech_status').hide();
            $('#tech_status').val(1);
        } else {
            $('#div_tech_status-group').show();
        }
    }


    /*==============================
     * Alert box
     ===============================*/
    /* Create alert for show above Form */
    function alertInit(alertType, alertTxt) {
        alertTxt = (typeof alertTxt === 'undefined') ? '...' : alertTxt;
        $("#formAlert").html(''); //clear

        var txtAlert = '<div class="alert alert-dismissible" role="alert" >' +
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">' +
                '<span aria-hidden="true">&times;</span>' +
                '</button>' +
                '<span class="txtAlert"></span>' +
                '</div>';
        $("#formAlert").html(txtAlert);

        if (alertType === 'success') {
            $("#formAlert .alert").addClass("alert-success");
        }
        else if (alertType === 'warning') {
            $("#formAlert .alert").addClass("alert-warning");
        }
        else if (alertType === 'info') {
            $("#formAlert .alert").addClass("alert-info");
        }
        else if (alertType === 'danger') {
            $("#formAlert .alert").addClass("alert-danger");
        }

        $("#formAlert span.txtAlert").html(alertTxt);

    }
    function alertShow() {
        $("#formAlert").show();
    }
    function alertHide() {
        $("#formAlert").hide();
    }


});

