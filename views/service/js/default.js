$(function() {
//    make by Shikaru
    var perPage = 10;
    var cPage = 0;
    var visiblePages = 7;
    var userType = $('#userType').val();
    var Session_searchText;
    var delay = 1000; //1 seconds
    var timer;

    /*** Coding Now ***/
    Session_searchText = $('#search').val();
    '<%Session["temp"] = "' + Session_searchText + '"; %>';

    clearForm();

    $('[data-toggle="popover"]').popover(); //enable all popovers in the document
//    $(".boss").popover({
//        container: 'body', //if button is inside .btn-group or .input-group
//        placement: 'bottom',
//        html: 'true',
//        title: '<span class="text-info"><strong>title</strong></span>' +
//                '<button type="button" id="close" class="close" onclick="$(&quot;#example&quot;).popover(&quot;hide&quot;);">&times;</button>',
//        content: 'test'
//    });

    callData($('#search').val(), $('#choose_service_status').val());

    $('.readOnly').prop('readonly', false);

    /*==================
     * Initial bootstrap's tooltip 
     ===================*/
    $('body').tooltip({
        selector: '[data-toggle="tooltip"]'
    });
    /*==========================================================*/



    /*
     * Start CallData Main ###########################################################################################################
     * Show Value table in main page
     */
    function callData(search, statusDetail, curPage) {
        var data;
        cPage = curPage;
        data = {'search': search, 'statusDetail': statusDetail, 'perPage': perPage};

        $.post('service/Pagination', data, function(o) {
            if (curPage <= 0) {
                cPage = curPage;
            }
            //alert('Pagination'+search);
            $('.pagin').empty();
            if (o.allPage > 1) {
                $('.pagin').append('<ul id="pagination" class="pagination-sm"></ul>');
                $('#pagination').twbsPagination({
                    totalPages: o.allPage,
                    startPage: cPage,
                    visiblePages: visiblePages,
                    onPageClick: function(event, page) {
                        $('.cls').empty();
                        callGetData(search, statusDetail, page);
                        return false;
                    }
                });
            }

            callGetData(search, statusDetail, cPage);
        }, 'json');
    }

    function callGetData(search, statusDetail, curPage) {
        var data;
        cPage = curPage;
        data = {'search': search, 'statusDetail': statusDetail, 'perPage': perPage, 'curPage': curPage};

        $.get('service/xhrGetSelect', data, function(o) {
            select_data = '';
            jobs = '';
            parts = '';
            for (var i = 0; i < o.length; i++) {
                color = 'style="background-color:' + o[i].status_color + ';"';

                if (o[i].jobs >= 1) {
                    jobs = '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'" align="left"><span class="glyphicon glyphicon-briefcase"></span></td>';

                } else {
                    jobs = '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'" align="left"></td>';
                }

                if (o[i].parts >= 1) {
                    parts = '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'" align="left"><span class="glyphicon glyphicon-wrench"></span></td>';
                } else {
                    parts = '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'" align="left"></td>';
                }

                if (userType === 'staff') {
//                    manage = '<td align="center"><button class="state btn btn-default btn-sm col-sm-12" rel="' + o[i].service_id + '" data-state-id="' + o[i].status_id + '" href="#" ><span class="glyphicon glyphicon-flag" aria-hidden="true"></span> ' + o[i].status_name + '</button></td>'
                    manage = '<td align="center"><button class="state btn btn-default btn-sm btn-block" rel="' + o[i].service_id + '" data-state-id="' + o[i].status_id + '" href="#" >' + o[i].status_name + '</button></td>'
                            + '<td align="center"><div class="btn-group">'
                            + '<button type="button" class="btn btn-sm btn-primary dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-menu-hamburger"></span></button>'
                            + '<ul class="dropdown-menu col-sm-2" role="menu">'
                            + '<li><a class="parts" href="#" rel="' + o[i].service_id + '"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ปฏิบัติ</a></li>'
                            + '<li><a class="edit" href="#" rel="' + o[i].service_id + '"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> แก้ไข</a></li>'
                            + '<li><a class="del" href="#" rel="' + o[i].service_id + '"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> ลบ</a></li>'
                            + '<li><a class="" href="service/pdfGen/' + o[i].service_id + '" target="_blank"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> พิมพ์</a></li>'
                            + '</ul>'
                            + '</td>';

                } else {
                    if (o[i].status_id === '1') {
                        manage = '<td align="center">'
                                + '<a class="edit btn btn-sm btn-info" rel="' + o[i].service_id + '" href="#"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>'
                                + '<a class="del btn btn-sm btn-danger" rel="' + o[i].service_id + '" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>'
                                + '</td>';
                    } else {
                        manage = '<td align="center">' + o[i].status_name + '</td>';
                    }


                }

                select_data += '<tr class="delTr' + o[i].service_id + ' cls" ' + color + '>'
                        + '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'">' + o[i].service_year + '/' + o[i].service_no + '</td>'
                        + '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'">' + o[i].items_code + '</td>'
                        + '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'">' + o[i].sn_scph + '</td>'
                        + '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'">' + o[i].depart_name + '</td>'
                        + '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'">' + o[i].brand + ' ' + o[i].model + '</td>'
                        + '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'" align="center">' + (o[i].service_servicedate !== null ? o[i].service_servicedate : '') + '</td>'
                        + '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'" align="left">' + o[i].sym_name + '</td>'
                        + '<td class="preview" rel="' + o[i].service_id + '" onmouseover="this.style.cursor=\'pointer\'" align="left">' + o[i].service_technician_name + '</td>'
                        + manage
                        + jobs
                        + parts
                        + '</tr>';
            }
            $('#select_service_data').append(select_data);
//                
//    ============================--- Start preview modal ---===================================
            $('.preview').on('click', function() {
                //--State Dialog--
                $('.frm-preview').modal("toggle");
                var service_id = $(this).attr('rel');
                $.post('service/getServicePreview/' + service_id, function(o) {
//                    Service
                    $('#collapseOne .service_id').html(o['service'][0].service_id);
                    $('#collapseOne .service_no').html(o['service'][0].service_no);
                    $('#collapseOne .service_year').html(o['service'][0].service_year);
                    $('#collapseOne .depart_name').html(o['service'][0].depart_name);
                    $('#collapseOne .service_type').html((o['service'][0].service_type === 'repair' ? 'แจ้งซ่อม' : 'แจ้งรายการอื่นๆ'));
                    $('#collapseOne .brand_model').html(o['service'][0].brand + ' ' + o['service'][0].model);
                    $('#collapseOne .items_depart_name').html('<a href="#" class="editItemsData" data-toggle="modal" data-target=".frm-edit-items" rel="' + o['service'][0].items_id + '">' + o['service'][0].items_id + o['service'][0].sn_scph + ' ' + o['service'][0].age_y + ' ' + o['service'][0].items_depart_name + '</a>');
                    $('#collapseOne .sym_name').html(o['service'][0].sym_name);
                    $('#collapseOne .service_symptom_text').html(o['service'][0].service_symptom_text);
                    $('#collapseOne .service_user').html(o['service'][0].service_user_name);
                    $('#collapseOne .service_technician').html(o['service'][0].service_technician_name);
                    $('#collapseOne .service_remark').html(o['service'][0].service_remark);
                    $('#collapseOne .service_status_name').html(o['service'][0].service_status_name);
                    $('#collapseOne .service_text').html(o['service'][0].service_text);
                    $('#collapseOne .service_servicedate').html(o['service'][0].service_servicedate);

//                      Edit items
                    $('.editItemsData').on('click', function() {
//                        $('#show_dialog').click();
//                        $('#div_items_id').show();
                        var items_id = $(this).attr('rel');

                        $.post('items/xhrSelectByID', {'items_id': items_id}, function(oi) {
                            $('.frm-edit-items #items_id').val(oi[0].items_id);
                            $('.frm-edit-items #items_group').val(oi[0].items_group);
                            $('.frm-edit-items #items_code').val(oi[0].items_code);
                            $('.frm-edit-items #sn_scph').val(oi[0].sn_scph);
                            $('.frm-edit-items #serial_number').val(oi[0].serial_number);
                            $('.frm-edit-items #hardware_id').val(oi[0].hardware_id);
                            $('.frm-edit-items #brand').val(oi[0].brand);
                            $('.frm-edit-items #model').val(oi[0].model);
                            $('.frm-edit-items #items_name').val(oi[0].items_name);
                            $('.frm-edit-items #ipaddress').val(oi[0].ipaddress);
                            $('.frm-edit-items #depart_id').val(oi[0].depart_id);
                            $('.frm-edit-items #buydate').val(oi[0].buydate);
                            $('.frm-edit-items #expdate').val(oi[0].expdate);
                            $('.frm-edit-items #sn_scph').focus();
                            oldItemsGroup = oi[0].items_group;
                            oldItemsCode = oi[0].items_code;
                        }, 'json');
//
//                        return false;
                    });

//                    Service_Detail
                    $('#preview_state_data').empty();
                    for (var i = 0; i < o['service_detail'].length; i++) {
                        $('#preview_state_data').append('<tr>'
                                + '<td>' + (i + 1) + '</td>'
                                + '<td>' + o['service_detail'][i].status_name + '</td>'
                                + '<td>' + o['service_detail'][i].service_detail_datetime + '</td>'
                                + '<td>' + o['service_detail'][i].service_detail_user_name + '</td>'
                                + '<td>' + o['service_detail'][i].service_detail_detail + '</td>'
                                + '</tr>'
                                );
                    }

//                    Jobs_items
                    if (o['jobs_items'].length) {
                        $('#panel3').show();
                        $('#preview_jobs_items').empty();
                        for (var i = 0; i < o['jobs_items'].length; i++) {
                            $('#preview_jobs_items').append('<tr>'
                                    + '<td>' + (i + 1) + '</td>'
                                    + '<td>' + o['jobs_items'][i].jobs_name + '</td>'
                                    + '<td>' + o['jobs_items'][i].jobs_unit_price + '</td>'
                                    + '<td>' + o['jobs_items'][i].jobs_qty + '</td>'
                                    + '<td>' + o['jobs_items'][i].jobs_sum_price + '</td>'
                                    + '<td>' + o['jobs_items'][i].jobs_date + '</td>'
                                    + '<td>' + o['jobs_items'][i].jobs_staff_name + '</td>'
                                    + '</tr>'
                                    );
                        }
                    } else {
                        $('#panel3').hide();
                    }

//                    Parts_items
                    if (o['parts_items'].length) {
                        $('#panel4').show();
                        $('#preview_parts_items').empty();
                        for (var i = 0; i < o['parts_items'].length; i++) {
                            $('#preview_parts_items').append('<tr>'
                                    + '<td>' + (i + 1) + '</td>'
                                    + '<td>' + o['parts_items'][i].store_type_name + '</td>'
                                    + '<td>' + o['parts_items'][i].store_name + '</td>'
                                    + '<td>' + o['parts_items'][i].serial_number + '</td>'
                                    + '<td>' + o['parts_items'][i].store_type_count + '</td>'
                                    + '<td>' + o['parts_items'][i].store_unit_price + '</td>'
                                    + '<td>' + o['parts_items'][i].parts_qty + '</td>'
                                    + '<td>' + o['parts_items'][i].store_sum_price + '</td>'
                                    + '<td>' + o['parts_items'][i].parts_date + '</td>'
                                    + '<td>' + o['parts_items'][i].parts_staff_name + '</td>'
                                    + '</tr>'
                                    );
                        }
                    } else {
                        $('#panel4').hide();
                    }

                }, 'json');
            });

//    ============================--- End preview modal ---===================================



            $('.del').on('click', function() {
                var service_id = $(this).attr('rel');
                delService = $('.delTr' + service_id);

                delConfirmDialog.realize();
                var delbtn = delConfirmDialog.getButton('del-btn-confirm');
                delbtn.click(function() {
                    $.post('service/xhrDeleteById', {'service_id': service_id}, function(o) {
                        if (o.chk) {
                            delService.empty();
                            $('.cls').empty();
                            callData('%');
                        } else {
                            alertDialog.setMessage('Conducted more than one event.\nDon\'t Delete!!!.');
                            alertDialog.open();
                        }
                        callData($('#item_type_id_Filter').val());
                        delConfirmDialog.close();
                    }, 'json'); // not use return json data
                });
                delConfirmDialog.open();
                return false;
            });

            $('.edit').on('click', function() {
                $('#show_dialog').click();
                $('#div_service_id').show();
                var service_id = $(this).attr('rel');
                if (service_id !== '') {
                    $('#btn_clear').hide();
                    $('#btn_reset').show();
                } else {
                    $('#btn_clear').show();
                    $('#btn_reset').hide();
                }

                $.post('service/xhrSelectByID', {'service_id': service_id}, function(o) {
                    $('#service_id').val(o[0].service_id);
                    $('#service_no').val(o[0].service_no);
                    $('#service_year').val(o[0].service_year);
                    $('#items_code').val(o[0].items_code);
                    $('#sn_scph').val(o[0].sn_scph);
                    $('#serial_number').val(o[0].serial_number);
                    $('#hardware_id').val(o[0].hardware_id);
                    $('#brand').val(o[0].brand);
                    $('#model').val(o[0].model);
                    $('#items_name').val(o[0].brand + ' ' + o[0].model);
                    $('#items_id').val(o[0].items_id);
                    $('#sn_scph').val(o[0].sn_scph + ' ' + o[0].items_depart_name);
                    $('#service_depart').val(o[0].service_depart);
                    $('#buydate').val(o[0].buydate);
                    $('#expdate').val(o[0].expdate);
                    $('#hardware_type_id').val(o[0].hardware_type_id);
                    $('#service_symptom_text').val(o[0].service_symptom_text);
                    $('#service_remark').val(o[0].service_remark);
                    $('#service_cause').val(o[0].service_cause);
                    $('#service_cause_text').val(o[0].service_cause_text);
                    $('#service_kpi3day').val(o[0].service_kpi3day);
                    $('#service_kpi3day_text').val(o[0].service_kpi3day_text);
                    $('#service_text').val(o[0].service_text);
                    $('#service_status_id').val(o[0].service_status_id);
                    $('#service_servicedate').val(o[0].service_servicedate);
                    // $('#service_user_name').val(o[0].service_user);

                    getItemSymptom(o[0].hardware_type_id, o[0].service_symptom);
                    callGetPersonDataById(o[0].service_user);
//                    $('#service_symptom').val(o[0].service_symptom);

                    if (o[0].service_type === 'repair') {
                        $('#service_type_1').prop("checked", true);
                    } else {
                        $('#service_type_2').prop("checked", true);
                    }
                    $('#sn_scph').focus();

                    //re-rendering selectpicker after assign value
                    $('.selectpicker').selectpicker('render');

                }, 'json');


                return false;
            });

            function getItemSymptom(hardware_type_id, selected) {
                $.post('service/getSymptom', {'hardware_type_id': hardware_type_id}, function(o) {
                    $('#service_symptom').empty(); //service_symptom
                    $('#service_symptom').append('<option value="0" selected>--เลือกอาการเสีย--</option>');
                    for (var i = 0; i < o.length; i++) {
                        if (selected === o[i].sym_id) {
                            $('#service_symptom').append('<option value="' + o[i].sym_id + '" selected>' + o[i].sym_name + '</option>');
                        } else {
                            $('#service_symptom').append('<option value="' + o[i].sym_id + '">' + o[i].sym_name + '</option>');
                        }
                    }
                }, 'json');
            }

            $('#btn_reset').on('click', function() {
//                $('#show_dialog').click();
//                $('#div_service_id').show();
                var service_id = $('#service_id').val();
                $.post('service/xhrSelectByID', {'service_id': service_id}, function(o) {
                    $('#service_id').val(o[0].service_id);
                    $('#service_year').val(o[0].service_year);
                    $('#sn_scph').val(o[0].sn_scph);
                    $('#serial_number').val(o[0].serial_number);
                    $('#hardware_id').val(o[0].hardware_id);
                    $('#brand').val(o[0].brand);
                    $('#model').val(o[0].model);
                    $('#items_id').val(o[0].items_id);
                    $('#items_name').val(o[0].brand + ' ' + o[0].model);
                    $('#sn_scph').val(o[0].sn_scph + ' ' + o[0].items_depart_name);
                    $('#service_depart').val(o[0].service_depart);
                    $('#buydate').val(o[0].buydate);
                    $('#expdate').val(o[0].expdate);
                    $('#hardware_type_id').val(o[0].hardware_type_id);
                    $('#service_symptom_text').val(o[0].service_symptom_text);
                    $('#service_remark').val(o[0].service_remark);
                    $('#service_text').val(o[0].service_text);
                    $('#service_status_id').val(o[0].service_status_id);
                    $('#service_servicedate').val(o[0].service_servicedate);
                    getItemSymptom(o[0].hardware_type_id, o[0].service_symptom);
                    //callGetPersonDataById($('#service_user').val());
                    callGetPersonDataById(o[0].service_user);
                    if (o[0].service_type === 'repair') {
                        $('#service_type_1').prop("checked", true);
                    } else {
                        $('#service_type_2').prop("checked", true);
                    }

                    $('#sn_scph').focus();
                }, 'json');
                return false;
            });

        }, 'json');
    }

    $('#search').on('keyup', function() {
        clearTimeout(timer);
        timer = setTimeout(function() {

            $('.cls').empty();
            $('#select_service_data').empty();
            if ($('#search').val() === '') {
                callData('%');
            } else {
                callData($('#search').val());

                Session_searchText = $('#search').val();
                '<%Session["temp"] = "' + Session_searchText + '"; %>';
            }
        }, delay);

    });

    $('#depart_id').on('change', function() {
        $('#choose_depart_id').val(this.value);
        $('#choose-items').removeAttr('disabled');
    });

    $('#btn_clear,#show_dialog').on('click', function() {
        clearForm();
        //callDataItems(0, hw_id, $('#choose_search_items').val());
//        return false;
    });
    $('#show_dialog').on('click', function() {
        $('#btn_clear').show();
        $('#btn_reset').hide();

        /* Clear validate */
        validator.resetForm(); //clear validate
        $("#service .form-group").removeClass('has-error');
        $("#service .glyphicon").removeClass('glyphicon-remove');
    });
    $('#btn_submit').on('click', function() {
        if ($('#service_id').val() !== "") {
            if (confirm("This data is Editing are you sure!\nEnter OK or Cancel.")) {
                $('#service').attr("action", 'service/xhrEditById/' + $('#userType').val());
                $(".close").click();
            } else {
                return false;
                exit();
            }
        } else {
            $('#service').attr("action", 'service/xhrInsert/' + $('#userType').val());
//            $('#service').attr("action", 'service/xhrInsert');
        }

        $('#service').submit();
        return false;
    });

    /*-- State change submit --*/
//    $('#btn_submit_change_state').on('click', function() {
//        submitChangeState();
//    });
//
//    function submitChangeState() {
//        var service_id = $('.frm-choose-state #service_id').val();
//        var status_id = $('.frm-choose-state #status_id').val();
//
//        if (service_id !== "" && status_id !== "")
//        {
//            $('#service').attr("action", 'service/xhrUpdateState');
//        }
//        return false;
//
//    }
    /*-------------------------*/

    function clearForm() {
        $('#service_symptom').empty();
        $('#service_type_1').prop("checked", true);
        $('#service_id,#items_id,#items_name,#service_symptom,#service_symptom_text,#sn_scph,#service_status_id,#service_symptom_text,#service_remark,#service_text').val('');
        $('#service_depart').val('');
        $('#service_coworker').val('');

        callGetPersonDataById($("#userPerson_id").val());


        $('#div_service_id').hide();
        $('#service_servicedate').datepicker({
            format: "yyyy-mm-dd",
            language: "th",
            autoclose: true,
            todayHighlight: true
        }).datepicker("setDate", new Date());

        //clear selectpicker and re-rendering
        $('.selectpicker').val('').selectpicker('render');

    }


    /*==============================
     * Form validation & Submit
     ===============================*/
    validator = $("#service").validate({
        ignore: [],
        rules: {
            service_id: {required: true},
            service_year: {required: true},
            service_type: {required: true},
            service_depart: {required: true, min: 1},
            items_name: {required: true},
            service_symptom: {required: true, min: 1},
            service_user: {required: true},
            service_remark: {required: true},
            service_status_id: {required: true},
            service_servicedate: {required: true}
        },
        messages: {
            service_id: {required: "Id is required!"},
            service_year: {required: "Service year is required!"},
            service_type: {required: "Service type is required!"},
            service_depart: {required: "Depart is required!", min: "Need to select Depart"},
            items_name: {required: "Items is required!"},
            service_symptom: {required: "Symptom is required!", min: "Need to select sympton"},
            service_user: {required: "User is required!"},
            service_remark: {required: "Remark is required!"},
            service_status_id: {required: "Status is required!"},
            service_servicedate: {required: "Service date is required!"}
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
            }
            else if (element.attr("name") === "service_depart") {
                error.insertAfter("form#service .bootstrap-select");
            }
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var url = $(form).attr('action');
            var data = $(form).serialize();
            $.post(url, data, function(o) {
                if (o.sta === 'add') {

                    $(".close").click();
                } else { // sta = edit or del
                }
                $(".cls").empty();
                clearForm();

                /*** Coding Now ***/

                Session_searchText = $('#search').val();
                '<%Session["temp"] = "' + Session_searchText + '"; %>';

                callData($('#search').val(), $('#choose_service_status').val(), cPage);
            }, 'json');
            return false;
        }
    });
    /*
     * end Calldata Main ###########################################################################################################
     */

    //cannot use jQuery Validate to check more than one input by not specific name
    //then I use normal validate by add 'require' in element
    $("form#partManagement").on("submit", function() {
        var form = $(this).get(0);

        var url = $(form).attr('action');
        var data = $(form).serialize();
        $.post(url, data, function(o) {
            if (o.sta === 'add') {

            } else { // sta = edit or del
                $(".close").click();
            }
            $(".cls").empty();
            clearForm();
            callData('%');

        }, 'json');

        return false;
    });

    //alert('In If...');
    //create by komsan 09/06/2558
    function callGetPersonDataById(person_id) {
        if (person_id > 0) {
            $.post('service/getPersonById', {'person_id': person_id}, function(o) {
                $('#service_user_name').val(o[0].prefix + o[0].firstname + ' ' + o[0].lastname);
                $('#service_user').val(o[0].person_id);
            }, 'json');
        } else {
            return false;
        }
    }
// 
//    $("form#partManagement").validate({
//        submitHandler: function (form) {
//            var url = $(form).attr('action');
//            var data = $(form).serialize();
//            $.post(url, data, function (o) {
//                if (o.sta === 'add') {
//                    search = '';
//                    depart = $("#depart_id").val();
//                    hardware = $("#hardware_id").val();
//                } else { // sta = edit or del
//                    search = $("#search").val();
//                    depart = $("#show_depart_id").val();
//                    hardware = $("#show_hardware_id").val();
//                    $(".close").click();
//                }
//                $(".cls").empty();
//                clearForm();
//                callData(depart, hardware, search);
//
//            }, 'json');
//
//            return false;
//        }
//    });


    //create by komsan 10/06/2558
//    function getServiceStatus(hardware_type_id, selected) {
//        $.post('service/getServiceStatus', {'service_status_id': service_status_id}, function(o) {
//            $('#service_symptom').empty(); //service_symptom
//            $('#service_symptom').append('<option value="0" selected>--เลือกอาการเสีย--</option>');
//            for (var i = 0; i < o.length; i++) {
//                if (selected === o[i].sym_id) {
//                    $('#service_symptom').append('<option value="' + o[i].sym_id + '" selected>' + o[i].sym_name + '</option>');
//                } else {
//                    $('#service_symptom').append('<option value="' + o[i].sym_id + '">' + o[i].sym_name + '</option>');
//                }
//            }
//        }, 'json');
//    }


    /*================================================================*/
    /*Preventing Bootstrap modal stacking removes browser scroll bar*/
    $('.modal').on('hidden.bs.modal', function(event) {
        $(this).removeClass('fv-modal-stack');
        $('body').data('fv_open_modals', $('body').data('fv_open_modals') - 1);
        $('.modal.fv-modal-stack').css('overflow-y', 'auto');
    });


    $('.modal').on('shown.bs.modal', function(event) {

        // keep track of the number of open modals
        if (typeof ($('body').data('fv_open_modals')) === 'undefined')
        {
            $('body').data('fv_open_modals', 0);
        }


        // if the z-index of this modal has been set, ignore.

        if ($(this).hasClass('fv-modal-stack'))
        {
            return;
        }

        $(this).addClass('fv-modal-stack');
        $('body').data('fv_open_modals', $('body').data('fv_open_modals') + 1);
        $(this).css('z-index', 1040 + (10 * $('body').data('fv_open_modals')));
        $('.modal-backdrop').not('.fv-modal-stack').css('z-index', 1039 + (10 * $('body').data('fv_open_modals')));
        $('.modal-backdrop').not('fv-modal-stack').addClass('fv-modal-stack');
    });
    /*================================================================*/





    /*    ==========================SetState===============================
     * 
     * 
     * 
     * 
     * 
     * 
     * 
     */


    function clearFormState() {
        $("#choose_service_detail_status_id").val(defaultSelect);
        $("#service_detail_text").val(defaultDetailTxt);
        $("#choose_service_detail_status_id").selectpicker("refresh");
        $("#choose_service_status").selectpicker("refresh");


        $('#service_coworker').val($("#userPerson_id").val()).selectpicker('refresh');
    }

//    --- Start state modal ---
    $("#select_service_data").on("click", ".state", function() {
        //--State Dialog--
        $('.frm-choose-state').modal("toggle");
        var service_id = $(this).attr('rel');
        var status_id = $(this).attr('data-state-id');
        defaultSelect = status_id;
        callDataState(service_id);
        $('.frm-choose-state #service_id').val(service_id);

        $('#service_coworker').val($("#userPerson_id").val()).selectpicker('refresh');

        //--detail status--
        $.post('service/getServiceDetailStatus', function(o) {
            $('#choose_service_detail_status_id').empty();
            for (var i = 1; i < o.length; i++) {
                selected = (status_id === o[i].status_id) ? 'selected' : '';
                disabled = (i === 1 || o[i].status_id === status_id) ? 'disabled' : '';
                allow_coworker = (o[i].allow_coworker === 'Y') ? 'data-allow-coworker=\'Y\'' : '';
                allow_borrow = (o[i].allow_borrow === 'Y') ? 'data-allow-borrow=\'Y\'' : '';
                $('#choose_service_detail_status_id').append('<option data-content="<span class=\'label\' style=\'background-color:' + o[i].status_color + ';\'>&nbsp;&nbsp;</span>&nbsp;&nbsp;' + o[i].status_name + '" value="' + o[i].status_id + '" ' + selected + ' ' + disabled + ' ' + allow_coworker + allow_borrow + '>' + o[i].status_name + '</option>');
            }

            SelectCoworker();
            $("#choose_service_detail_status_id").selectpicker("refresh");
        }, 'json');

        //--detail text--
        $.post('service/getServiceDetailText', {'service_id': service_id}, function(o) {
            $("#service_detail_text").val(o[0].detailText);
            defaultDetailTxt = o[0].detailText;
        }, 'json');

    });

    function callDataState(service_id) {
        $('.cls-state').empty();
        $.post('service/getServiceDetail', {'service_id': service_id}, function(o) {
            for (var i = o.length; i >= 0; i--) {
                $('#state_data').append('<tr class="cls-state">'
                        + '<td>' + i-- + '</td>'
                        + '<td>' + o[i].status_name + '</td>'
                        + '<td>' + o[i].service_detail_datetime + '</td>'
                        + '<td>' + o[i].service_detail_user_name + '</td>'
                        + '<td>' + o[i].service_detail_detail + '</td>'
                        + '<td class="text-center"><a class="del_service_detail btn btn-sm btn-danger" rel="' + o[i].service_detail_id + '" data-service_id="' + o[i].service_id + '" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>'
                        + '</tr>'
                        );
            }

        }, 'json');
    }

    $(".frm-choose-state").on("click", "#btn_reset_state_change", function() {
        clearFormState();
    }).on("click", ".del_service_detail", function() {
        var service_id = $(this).attr('data-service_id');
        var service_detail_id = $(this).attr('rel');
        $.post('service/chkCoworker', {'service_id': service_id}, function(o) {
            if (o[0].cc > 1) {
                if (confirm("คุณต้องการลบ ใช่หรือไม่?")) {
                    $.post('service/delServiceDetail', {'service_id': service_id, 'service_detail_id': service_detail_id});
                    callDataState(service_id);

                    $('#select_service_data').empty();
                    callData('%');
                }
            } else {
                alert('ลบไม่ได้ นี่เป็นสถานะสุดท้ายแล้ว');
            }
        }, 'json');
    });

    $('#choose_service_detail_status_id').on('change', function() {
        $("#service_detail_text").val('');
        $('#service_coworker').val($("#userPerson_id").val()).selectpicker('refresh');
        $('#service_borrow').val($("#userPerson_id").val()).hide;

        SelectCoworker();
        SelectBorrow();
    });


//**************** ๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒๒
    $('#choose_service_status').on('change', function() {
        $("#service_detail_text").val('');
        $('#service_coworker').val($("#userPerson_id").val()).selectpicker('refresh');

        SelectCoworker();
    });


    function SelectCoworker() {
        if ($('#choose_service_detail_status_id option:selected').attr("data-allow-coworker") === 'Y') {
            $("#service_coworker").prop('disabled', false);
            $("#service_coworker").selectpicker('refresh');
            $(".div_service_coworker").show();
        } else {
            $("#service_coworker").prop('disabled', true);
            $("#service_coworker").selectpicker('refresh');
            $(".div_service_coworker").hide();
        }
    }
    
//    make by Kitarblue
    //**************** Borrow Items **************//
    function SelectBorrow() {
        if ($('#choose_service_detail_status_id option:selected').attr("data-allow-borrow") === 'Y') {
            $("#service_borrow").prop('disabled', false);
            $(".div_service_borrow").show();
        } else {
            $("#service_borrow").prop('disabled', true);
            $(".div_service_borrow").hide();
        }
    }

    /*-- State change submit --*/
    $('#btn_submit_change_state').on('click', function() {
//        alert(defaultSelect);
        submitChangeState();
    });

    function submitChangeState() {
        var service_id = $('.frm-choose-state #service_id').val();
        var status_id = $('.frm-choose-state #choose_service_detail_status_id').val();
        var service_detail_text = $('.frm-choose-state #service_detail_text').val();

        var updateTime = todayYMD();
        var updateUser = $("#userPerson_id").val();
        var coworker = $("#service_coworker").val();

        var data = {
            'service_id': service_id,
            'service_detail_datetime': updateTime,
            'service_detail_status_id': status_id,
            'service_detail_user': updateUser,
            'service_detail_detail': service_detail_text,
            'coworker': coworker
        };
        if (status_id === null) {
            alert('ปัจจุบันมีสถานะนี้อยู่แล้ว');
            exit();
        } else {
            if (service_id !== "" && status_id !== "") {
                $.ajax({
                    url: 'service/xhrUpdServiceDetail',
                    data: data,
                    type: 'post',
                    dataType: 'json',
                    success: function(o) {
                        if (o.chk) {
                            defaultSelect = $("#choose_service_detail_status_id").val();
                            defaultDetailTxt = $("#service_detail_text").val();

                            $(".cls").empty();
                            clearFormState();
                            callData('%');
                            $(".frm-choose-state").modal("toggle"); //close modal  
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alert('error');
                    }
                });

            }
        }
//            $(".frm-choose-state").modal("toggle"); //close modal
        return false;

    }
    /*    
     * 
     * 
     * 
     * 
     * 
     * 
     *  ==========================SetState===============================
     */


    /**************************************
     * Search by Detail Status
     **************************************/

    //-->create search dropdown
    setSelectDetailStatus();
    function setSelectDetailStatus() {
        //--detail status--
        $.post('service/getServiceDetailStatus', function(o) {
            $('#choose_service_status').empty();
            for (var i = 1; i < o.length; i++) {

                $('#choose_service_status').append('<option data-content="<span class=\'label\' style=\'background-color:' + o[i].status_color + ';\'>&nbsp;&nbsp;</span>&nbsp;&nbsp;' + o[i].status_name + '" value="' + o[i].status_id + '" >' + o[i].status_name + '</option>');

            }

            $("#choose_service_status").selectpicker("refresh");
        }, 'json');

    }
    $('#choose_service_status').on('change', function() {

        $('.cls-parts').empty();
        $('#select_service_data').empty();
        var valDetail = $(this).val(); //will return like this "1,2,3,5,....."
        callData($('#search').val(), $('#choose_service_status').val());
    });

});

$(document).on("focusin", ".readOnly", function(event) {

    $(this).prop('readonly', true);

});

$(document).on("focusout", ".readOnly", function(event) {

    $(this).prop('readonly', false);

});
