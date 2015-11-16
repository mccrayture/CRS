$(function() {
    /*
     * Start CallDataParts  *---------------------------------------------//
     * Button [Choose Parts]
     * Show Value table in Dialog(model)
     */

    //Create By Komsan 08/07/2558
    perPage_Parts = 5;
    perPage_Jobs = 5;
    visiblePages_Parts = 5;
    visiblePages_Jobs = 5;
    var arrJobsItems = new Array(2);
    var arrPartsItems = new Array(2);
    var service_id;
    var arrJobs = document.createElement("INPUT");
    arrJobs.setAttribute("type", "hidden");
    arrJobs.setAttribute("id", "arrJobs");
    var modified_user = $("#userPerson_id").val();
    var sumPriceAllJobs = 0.00;
    var sumPriceAllParts = 0.00;

    document.body.appendChild(arrJobs);
    arrJobsItems = [];
    arrPartsItems = [];

    $('#select_service_data').on('click', '.parts', function() {
        arrJobsItems = [];
        arrPartsItems = [];
        $('#sum_price_all_jobs').val(0.00);
        $('#sum_price_all_parts').val(0.00);
        $('#sumAllService').text(0.00);
        $('#sumAllServiceThaiBaht').text('....');

        $('.frm-choose-partManagement').modal("toggle");
        service_id = $(this).attr('rel');
        $('.cls-partsManage').empty();
        $('.cls-jobsManage').empty();

        $.post('service/xhrSelectByID', {'service_id': service_id}, function(o) {
            $('#service_items_name').text(o[0].brand + ' ' + o[0].model + ' ' + o[0].sn_scph + ' ' + o[0].items_depart_name);

            $("#serviceInfo-panel").remove();

            var infohtml =
                    "<div class='panel-group' id='serviceInfo-panel'>" +
                    "<div class='panel panel-default'>" +
                    "<div class='panel-heading' data-toggle='collapse' data-target='#serviceInfo' style='cursor: pointer;'>" +
                    "<h4 class='panel-title'>" +
                    "<a data-toggle='collapse' data-target='#serviceInfo'></a> รายละเอียดรายการส่งซ่อม" +
//                                        "<span class='glyphicon glyphicon-chevron-down'> รายละเอียดรายการส่งซ่อม</span> " +
                    "</h4>" +
                    "</div>" +
                    "<div id='serviceInfo' class='panel-collapse collapse'>" +
                    "<div class='panel-body'>" +
                    "<div class='row'>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>เลขที่ :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].service_id + "</div>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>ปีงบประมาณ :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].service_year + "</div>" +
                    "</div>" +
                    "<div class='row'>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>หน่วยงาน :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].depart_name + "</div>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>เรื่อง :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + (o[0].service_type === 'repair' ? 'ขออนุมัติซ่อม' : 'ขออนุมัติอื่นๆ') + "</div>" +
                    "</div>" +
                    "<div class='row'>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>ชื่ออุปกรณ์ :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].brand + o[0].model + "</div>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>เลขครุภัณฑ์ :</strong></div>" + //items/xhrSelectByID/" + o[0].items_id + "
                    "<div class='col-xs-6 col-lg-4 text-left'><a href='#' class='editItems' data-toggle='modal' data-target='.frm-edit-items' rel='" + o[0].items_id + "'>" + o[0].sn_scph + ' ' + o[0].items_depart_name + "</a></div>" +
                    "</div>" +
                    "<div class='row'>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>อาการเสีย :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].sym_name + "</div>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>หมายเหตุ :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].service_symptom_text + "</div>" +
                    "</div>" +
                    "<div class='row'>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>ผู้ส่งซ่อม :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].service_user_name + "</div>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>เจ้าหน้าที่บันทึกการซ่อม :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].service_technician_name + "</div>" +
                    "</div>" +
                    "<div class='row'>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>สาเหตุ :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].service_remark + "</div>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>การซ่อม :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].service_status_name + "</div>" +
                    "</div>" +
                    "<div class='row'>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>รายละเอียด :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].service_text + "</div>" +
                    "<div class='col-xs-6 col-lg-2 text-left'><strong>วันที่รับเรื่อง :</strong></div>" +
                    "<div class='col-xs-6 col-lg-4 text-left'>" + o[0].service_servicedate + "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>";

            $(".frm-choose-partManagement #gridSystemModalLabel").after(infohtml);
            $("#serviceInfo").collapse('show');

        }, 'json');

        callDataJobsItems(service_id, perPage_Jobs);
        callDataPartsItems(service_id, perPage_Parts);

    });

    function callDataJobsItems(service_id, perPage_Jobs) {
        var search = '';

        $.post('jobs_items/Pagination', {'id': service_id, 'perPage': perPage_Parts}, function(o) {
            $('.pagin-jobs').empty();
            if (o.allPage > 1) {
                $('.pagin-jobs').append('<ul id="pagination-jobs" class="pagination-sm"></ul>');
                $('#pagination-jobs').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages_Jobs,
                    onPageClick: function(event, page) {
                        $('.cls-jobsManage').empty();
                        callGetJobsItemsData(service_id, search, page);
                        return false;
                    }
                });
            }
            callGetJobsItemsData(service_id, search, 1);
        }, 'json');
    }

    function callGetJobsItemsData(service_id, search, curPage) {
        arrJobsItems = [];
        $.get('jobs_items/xhrGetSelect', {'service_id': service_id, 'search': search, 'perPage': 100, 'curPage': curPage}, function(o) {

            for (var i = 0; i < o.length; i++) {
                arrJobsItems[i] = {
                    "jobs_items_id": o[i].jobs_items_id,
                    "service_id": service_id,
                    "jobs_id": o[i].jobs_id,
                    "jobs_name": o[i].jobs_name,
                    "jobs_unit_price": o[i].jobs_unit_price,
                    "jobs_qty": o[i].jobs_qty,
                    "jobs_sum_price": o[i].jobs_sum_price,
                    "jobs_date": o[i].jobs_date,
                    "jobs_staff": o[i].jobs_staff_name,
                    "jobs_modified": o[i].jobs_modified,
                    "hos_guid_jobs": o[i].hos_guid_jobs,
                    "hos_guid": o[i].hos_guid,
                    "manage": 'old'
                };
            }
            showTableJobsItemsData(arrJobsItems);
        }, 'json');
    }

    function showTableJobsItemsData(arrJobsItems) {
        $('#select_jobsManagement_data').empty();
        $('#sum_price_all_jobs').val(0.00);

        $('.cls-jobsManage').empty();
        var jobs_date = new Date();
        for (var i = 0; i < arrJobsItems.length; i++) {
            if (arrJobsItems[i].manage !== 'delete') {

                $('#select_jobsManagement_data').append('<tr class="cls-jobsManage jobsRow-' + i + '" align="center"><td data-title="#">' + (i + 1) + '</td>'
                        + '<td data-title="รายการ" align="left" >' + arrJobsItems[i].jobs_name + '</td>'
                        + '<td data-title="ราคา/หน่วย" align="right" ><input type="number" maxlength="10" class="text-right" id="jobs_unit_price-' + i + '"  value="' + arrJobsItems[i].jobs_unit_price + '"  required></input></td>'
                        + '<td data-title="จำนวน" align="right" ><input type="number" maxlength="4" class="text-right" id="jobs_qty-' + i + '" value="' + arrJobsItems[i].jobs_qty + '"  required></input></td>'
                        + '<td data-title="ราคารวม" class="text-right"><label id="jobs_sum_price-' + i + '"  name="jobs_sum_price-' + i + '">' + formatCurrency(arrJobsItems[i].jobs_sum_price) + '</label></td>'
                        + '<td data-title="วันที่"><input type="text" id="jobs_date-' + i + '" name="jobs_date-' + i + '" aria-invalid="false"></td>'
                        + '<td data-title="เจ้าหน้าที่"><input type="text" class="text-right" id="jobs_staff-' + i + '" value="' + arrJobsItems[i].jobs_staff + '" disabled ></input></td>'
                        + '<td data-title="ลบ"><a class="del btn btn-sm btn-danger" rel="' + i + '" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>'
                        + '<td data-title="jobs_items_id" style="display: none;">' + arrJobsItems[i].jobs_items_id + '</td>'
                        + '<td data-title="hos_guid" style="display: none;">' + arrJobsItems[i].hos_guid_jobs + '</td>'
                        + '<td data-title="manage" style="display: none;">' + arrJobsItems[i].manage + '</td>'
                        + '</tr>'
                        );

                if (arrJobsItems[i].jobs_date === '') {
                    jobs_date = new Date();
                } else {
                    jobs_date = arrJobsItems[i].jobs_date;
                }

                $('#jobs_date-' + i).datepicker({
                    format: "yyyy-mm-dd",
                    language: "th",
                    autoclose: true,
                    todayHighlight: true
                }).datepicker("setDate", jobs_date);
                //}).datepicker("setDate", new Date());

            }
        }
        sumPriceJobs();

        $("#arrJobs").val(JSON.stringify(arrJobsItems));
    }


    function callDataPartsItems(service_id, perPage_Parts) {
        var search = '';

        $.post('parts_items/Pagination', {'id': service_id, 'perPage': perPage_Parts}, function(o) {
            $('.pagin-partsManage').empty();
            if (o.allPage > 1) {
                $('.pagin-parts').append('<ul id="pagination-parts" class="pagination-sm"></ul>');
                $('#pagination-parts').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages_Parts,
                    onPageClick: function(event, page) {
                        $('.cls-partsManage').empty();
                        callGetPartsItemsData(service_id, search, page);
                        return false;
                    }
                });
            }

            callGetPartsItemsData(service_id, search, 1);
        }, 'json');
    }

    function callGetPartsItemsData(service_id, search, curPage) {
        arrPartsItems = [];
        $.get('parts_items/xhrGetSelect', {'service_id': service_id, 'search': search, 'perPage': 100, 'curPage': curPage}, function(o) {

            for (var i = 0; i < o.length; i++) {
                arrPartsItems[i] = {
                    "service_id": service_id,
                    "store_lotno": o[i].store_lotno,
                    "store_type_name": o[i].store_type_name,
                    "store_id": o[i].store_id,
                    "store_name": o[i].store_name,
                    "serial_number": o[i].serial_number,
                    "store_type_count": o[i].store_type_count,
                    "parts_qty": o[i].parts_qty,
                    "qty_old": o[i].parts_qty,
                    "parts_qty_old": o[i].parts_qty,
                    "store_type_keeping": o[i].store_type_keeping,
                    "parts_stock": o[i].stock,
                    "parts_unit_price": o[i].store_unit_price,
                    "parts_sum_price": o[i].store_sum_price,
                    "parts_date": o[i].parts_date,
                    "store_adddate": o[i].store_adddate,
                    "parts_staff": o[i].parts_staff,
                    "parts_modified": o[i].parts_modified,
                    "parts_items_id": o[i].parts_items_id,
                    "hos_guid": o[i].hos_guid,
                    "manage": 'old'
                };
            }

            showTablePartsItemsData(arrPartsItems);
        }, 'json');
    }

    function showTablePartsItemsData(arrPartsItems) {

        var store_max_count = '';
        var parts_date = new Date();
        $('.cls-partsManage').empty();
        $('#sum_price_all_parts').val(0.00);
        //alert('arrPartsItems.length := ' + arrPartsItems.length);
        for (var i = 0; i < arrPartsItems.length; i++) {
            if (arrPartsItems[i].manage !== 'delete') {
                if (arrPartsItems[i].store_type_keeping === 'serial') {
                    store_max_count = '<td data-title="จำนวน" class="text-right"><label id="parts_items_id-' + i + '" name="parts_items_id-' + i + '">' + arrPartsItems[i].parts_qty + '</label><input type="hidden" id="parts_qty-' + i + '" name="parts_qty-' + i + '" value="' + arrPartsItems[i].parts_qty + '"></td>';
                    store_max_count = store_max_count + '<td data-title="รวมราคา"><label class="text-right" id="parts_sum_price-' + i + '" name="parts_sum_price-' + i + '">' + formatCurrency(arrPartsItems[i].parts_sum_price) + '</label></td>';
                    store_max_count = store_max_count + '<td data-title="วันที่" class="text-center"><input id="parts_date-' + i + '" name="parts_date-' + i + '" type="text" aria-invalid="false"></td>';
                    store_max_count = store_max_count + '<td data-title="คงเหลือ" class="text-right">' + arrPartsItems[i].parts_qty + '<input type="hidden" id="parts_nMax-' + i + '" name="parts_nMax-' + i + '" value = "' + arrPartsItems[i].parts_stock + '"></td>';
                } else {
                    store_max_count = '<td data-title="จำนวน"><input type="number" maxlength="4" size="4" class="text-right" id="parts_qty-' + i + '" name="parts_qty-' + i + '" value="' + arrPartsItems[i].parts_qty + '" /></td>';
                    store_max_count = store_max_count + '<td data-title="รวมราคา"><label class="text-right" id="parts_sum_price-' + i + '" name="parts_sum_price-' + i + '">' + formatCurrency(arrPartsItems[i].store_sum_price) + '</label></td>';
                    store_max_count = store_max_count + '<td data-title="วันที่" class="text-center"><input id="parts_date-' + i + '" name="parts_date-' + i + '" type="text" aria-invalid="false"></td>';
                    store_max_count = store_max_count + '<td data-title="คงเหลือ" class="text-right">' + arrPartsItems[i].parts_stock + '<input type="hidden" id="parts_nMax-' + i + '" name="parts_nMax-' + i + '" value = "' + arrPartsItems[i].parts_stock + '"></td>';
                }
                $('#select_partManagement_data').append('<tr class="cls-partsManage partsRow-' + i + ' "><td data-title="#">' + (i + 1) + '</td>'
                        + '<td data-title="ใบสั่งซื้อ">' + arrPartsItems[i].store_lotno + '</td>'
                        + '<td data-title="ประเภท">' + arrPartsItems[i].store_type_name + '</td>'
                        + '<td data-title="รุ่น">' + arrPartsItems[i].store_name + '</td>'
                        + '<td data-title="SERIAL" class="text-center">' + arrPartsItems[i].serial_number + '&nbsp;</td>'
                        + '<td data-title="หน่วยนับ" class="text-center">' + arrPartsItems[i].store_type_count + '&nbsp;</td>'
                        + '<td data-title="ราคา/หน่วย" class="text-center">' + formatCurrency(arrPartsItems[i].store_sum_price) + '<input type="hidden" id="parts_unit_price-' + i + '" name="parts_unit_price-' + i + '" value="' + arrPartsItems[i].parts_unit_price + '"></td>'
                        + store_max_count
                        + '<td data-title="ลบ" class="text-center"><a class="del btn btn-sm btn-danger" rel="' + i
                        + '" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>'
                        + '<td data-title="parts_items_id" class="text-center" style="display: none;" >' + arrPartsItems[i].parts_items_id + '</td>'
                        + '<td data-title="qty_old" class="text-right" style="display: none;" >' + arrPartsItems[i].qty_old + '<input type="hidden" id="qty_old-' + i + '" name="qty_old-' + i + '" value="' + arrPartsItems[i].qty_old + '"></td>'
                        + '<td data-title="hos_guid" class="text-center" style="display: none;" >' + arrPartsItems[i].hos_guid + '</td>'
                        + '<td data-title="manage" class="text-center" style="display: none;" >' + arrPartsItems[i].manage + '</td>'
                        + '</tr>'
                        );

                if (arrPartsItems[i].parts_date === '') {
                    parts_date = new Date();
                } else {
                    parts_date = arrPartsItems[i].parts_date;
                }
                $('#parts_date-' + i).datepicker({
                    format: "yyyy-mm-dd",
                    language: "th",
                    autoclose: true,
                    todayHighlight: true
                }).datepicker("setDate", parts_date);

            }
        }
        sumPriceParts();

        $("#arrParts").val(JSON.stringify(arrPartsItems));
        return false;
    }

    function duplicateCheckJobsInArray(arrJobsItems, currCode) {
        for (var i = 0; i < arrJobsItems.length; i++) {
            if (arrJobsItems[i].hos_guid_jobs === currCode && arrJobsItems[i].manage !== 'delete') {
                return true;
            }
        }
        return false;
    }

    function duplicateCheckPartsInArray(arrPartsItems, currCode) {
        for (var i = 0; i < arrPartsItems.length; i++) {
            if (arrPartsItems[i].hos_guid === currCode && arrPartsItems[i].manage !== 'delete') {
                return true;
            }
        }
        return false;
    }

    //Search Jobs-Parts Items
    $('#choose_search_jobs').on('keyup', function() {
        $('#select_jobs_data').empty();
        callDataJobs(this.value);
    });

    $('#choose_search_parts').on('keyup', function() {
        $('#select_parts_data').empty();
        if ($('#show_store_type_id').val() > 0) {
            callDataParts($('#show_store_type_id').val(), this.value);
        } else {
            callDataParts('', this.value);
        }
    });

    function callDataParts(store_type_id, search) {
        $.post('service/Pagination/store', {'store_type_id': store_type_id, 'search': search, 'perPage': perPage_Parts}, function(o) {
            $('.pagin-parts').empty();
            if (o.allPage > 1) {
                $('.pagin-parts').append('<ul id="pagination-parts" class="pagination-sm"></ul>');
                $('#pagination-parts').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages_Parts,
                    onPageClick: function(event, page) {
                        $('.cls-parts').empty();
                        callGetPartsData(store_type_id, search, page);
                        return false;
                    }
                });
            }
            callGetPartsData(store_type_id, search, 1);
        }, 'json');
    }

    function callGetPartsData(store_type_id, search, curPage) {
        $.get('service/getStore', {'store_type_id': store_type_id, 'search': search, 'perPage': perPage_Parts, 'curPage': curPage}, function(o) {
            for (var i = 0; i < o.length; i++) {
                $('#select_parts_data').append('<tr class="cls-parts"><td>' + (i + 1) + '</td>'
                        + '<td>' + o[i].store_lotno + '</td>'
                        + '<td>' + o[i].store_type_name + '</td>'
                        + '<td>' + o[i].store_name + '</td>'
                        + '<td align="center">' + o[i].serial_number + '</td>'
                        + '<td align="right">' + o[i].store_type_count + '</td>'
                        + '<td align="right">' + o[i].store_max_count + '</td>'
                        + '<td align="center">' + o[i].store_adddate + '</td>'
                        + '<td align="center"><a class="choose-parts" rel="' + o[i].store_id + '" data-store_lotno="' + o[i].store_lotno
                        + '" data-store_type_name="' + o[i].store_type_name + '" data-store_name="' + o[i].store_name + '"'
                        + '" data-serial_number="' + o[i].serial_number + '" data-store_type_count="' + o[i].store_type_count + '"'
                        + '" data-stock="' + o[i].store_stock + '"' + '" data-store_adddate="' + o[i].store_adddate + '"'
                        + '" data-store_type_keeping="' + o[i].store_type_keeping + '"' + '" data-store_unit_price="' + o[i].store_unit_price + '"'
                        + '" data-store_sum_price="' + o[i].store_sum_price + '"'
                        + '" data-hos_guid="' + o[i].hos_guid + '"'
                        + '" href="#">Choose</a></td>'
                        + '</tr>'
                        );
            }
        }, 'json');
    }

    function callDataJobs(search) {
        $.post('service/Pagination/jobs', {'search': search, 'perPage': perPage_Jobs}, function(o) {
            $('.pagin-jobs').empty();
            if (o.allPage > 1) {
                $('.pagin-jobs').append('<ul id="pagination-jobs" class="pagination-sm"></ul>');
                $('#pagination-jobs').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages_Jobs,
                    onPageClick: function(event, page) {
                        $('.cls-jobs').empty();
                        callGetJobsData(search, page);
                        return false;
                    }
                });
            }
            callGetJobsData(search, 1);
        }, 'json');
    }

    function callGetJobsData(search, curPage) {
        $.get('service/getJobs', {'search': search, 'perPage': perPage_Parts, 'curPage': curPage}, function(o) {
            for (var i = 0; i < o.length; i++) {
                if (o[i].expire === '1') {
                    danger = 'warning';
                } else {
                    danger = '';
                }
                $('#select_jobs_data').append('<tr class="cls-jobs ' + danger + '" width="40px""><td>' + (i + 1) + '</td>'
                        + '<td width="400px">' + o[i].jobs_name + '</td>'
                        + '<td width="100px">' + o[i].jobs_unit_price + '</td>'
                        + '<td width="100px">' + o[i].jobs_group_name + '</td>'
                        + '<td align="center"><a class="choose-jobs" rel="' + o[i].jobs_id + '" data-jobs_name="' + o[i].jobs_name
                        + '" data-jobs_unit_price="' + o[i].jobs_unit_price + '" '
                        + '" data-hos_guid_jobs="' + o[i].hos_guid + '"'
                        + '" href="#">Choose</a></td>'
                        + '</tr>'
                        );
            }

        }, 'json');
    }

    $('#select_jobs_data').on('click', '.choose-jobs', function() {
        if (duplicateCheckJobsInArray(arrJobsItems, $(this).attr('data-hos_guid_jobs')) === true) {
            alert('ถูกเลือกไปแล้ว');
            return false;
        } else {
            var i = arrJobsItems.length;

            arrJobsItems[i] = {
                "jobs_items_id": '',
                "service_id": service_id,
                "jobs_id": $(this).attr('rel'),
                "jobs_name": $(this).attr('data-jobs_name'),
                "jobs_unit_price": $(this).attr('data-jobs_unit_price'),
                "jobs_qty": '1',
                "jobs_sum_price": $(this).attr('data-jobs_unit_price'),
                "jobs_staff": $("#userPerson_id").val(),
                "jobs_date": new Date(),
                "jobs_modified": modified_user,
                "hos_guid_jobs": $(this).attr('data-hos_guid_jobs'),
                "hos_guid": '',
                "manage": 'new'
            };
        }

        showTableJobsItemsData(arrJobsItems);
        $('.frm-choose-jobs').modal("toggle");
    });

    /* when chossing Parts "CHOOSE" in table list */
    $('#select_parts_data').on('click', '.choose-parts', function() {
        if (duplicateCheckPartsInArray(arrPartsItems, $(this).attr('data-hos_guid')) === true) {
            alert('ถูกเลือกไปแล้ว');
            return false;
        } else {
            var i = arrPartsItems.length;

            arrPartsItems[i] = {
                "service_id": service_id,
                "store_lotno": $(this).attr('data-store_lotno'),
                "store_type_name": $(this).attr('data-store_type_name'),
                "store_id": $(this).attr('rel'),
                "store_name": $(this).attr('data-store_name'),
                "serial_number": $(this).attr('data-serial_number'),
                "store_type_count": $(this).attr('data-store_type_count'),
                "parts_qty": $(this).attr('data-stock'),
                "qty_old": $(this).attr('data-stock'),
                "parts_stock": $(this).attr('data-stock'),
                "parts_date": new Date(),
                "parts_unit_price": $(this).attr('data-store_unit_price'),
                "parts_sum_price": $(this).attr('data-store_sum_price'),
                "store_type_keeping": $(this).attr('data-store_type_keeping'),
                "store_adddate": $(this).attr('data-store_adddate'),
                "parts_staff": $("#userPerson_id").val(),
                "hos_guid": $(this).attr('data-hos_guid'),
                "manage": 'new'
            };
        }

        showTablePartsItemsData(arrPartsItems);
        $('.frm-choose-parts').modal("toggle");

    });

    function sumPriceJobs() {
        sumPriceAllJobs = 0.00;
        $("#sum_price_all_jobs").val('0.00');

        for (var i = 0; i < arrJobsItems.length; i++) {
            if (arrJobsItems[i].manage !== 'delete') {
                sumPriceAllJobs = sumPriceAllJobs + parseFloat(arrJobsItems[i].jobs_sum_price);
            }
        }
        $("#sum_price_all_jobs").val(formatCurrency(sumPriceAllJobs.toFixed(2)));
        sumPriceAllService();
    }

    function sumPriceParts() {
        sumPriceAllParts = 0.00;
        $("#sum_price_all_parts").val('0.00');

        for (var i = 0; i < arrPartsItems.length; i++) {
            if (arrPartsItems[i].manage !== 'delete') {
                sumPriceAllParts = sumPriceAllParts + parseFloat(arrPartsItems[i].parts_sum_price);
            }
        }
        $("#sum_price_all_parts").val(formatCurrency(sumPriceAllParts.toFixed(2)));
        sumPriceAllService();
    }

    function sumPriceAllService() {
        var sumMoney = 0.00;
        $('#sumAllService').text(0.00);
        $('#sumAllServiceThaiBaht').text('....');
        sumMoney = sumPriceAllJobs + sumPriceAllParts;

        $("#sumAllService").text(formatCurrency(sumMoney.toFixed(2)));
        $("#sumAllServiceThaiBaht").text(ThaiBaht(sumMoney.toFixed(2)));
    }

    /* Select parts in new modal */
    $('#choose-parts').on('click', function() {
        $('#show_store_type_id').val(0);
        $('#choose_store_id').val(0);
        $('#choose_search_parts').val('');
        $('#choose_parts_id').attr('disabled', 'disabled');
        $('.cls-parts').empty();
        $('.pagin-parts').empty();
        callDataParts();
    });

    $('#choose-jobs').on('click', function() {
        $('#choose_jobs_id').val(0);
        $('#choose_search_jobs').val('');
        $('#choose_jobs_id').attr('disabled', 'disabled');
        $('.cls-jobs').empty();
        $('.pagin-jobs').empty();
        callDataJobs();
    });

    //delete Jobs Items
    $('#select_jobsManagement_data').on('click', '.del', function() {
        if (confirm("ต้องการลบรายการงานซ่อม!\n กดปุ่ม OK หรือ Cancel.")) {
            var curIndex = $(this).attr('rel');
            arrJobsItems[curIndex].manage = 'delete';
            showTableJobsItemsData(arrJobsItems);
            return true;
        } else {
            return false;
            exit();
        }
        return false;
    });

    //delete Parts Items
    $('#select_partManagement_data').on('click', '.del', function() {

        if (confirm("ต้องการลบรายการอะไหล่!\n กดปุ่ม OK หรือ Cancel.")) {
            var curIndex = $(this).attr('rel');
            // alert(curIndex);
            arrPartsItems[curIndex].manage = 'delete';
            showTablePartsItemsData(arrPartsItems);
            return true;
        } else {
            return false;
            exit();
        }
        return false;
    });


    $('#select_partManagement_data').on('change', 'input[id^="parts_qty-"]', function() {

        var nId = $(this).attr('id').substring(10);
        var sumPrice = parseFloat($("#parts_unit_price-" + nId).val() * parseFloat($(this).val()));

        var allParts = (parseInt($("#parts_nMax-" + nId).val()) + parseInt($("#qty_old-" + nId).val()));

        if (parseInt($(this).val(), 10) > allParts) {
            alert('กรอกจำนวนมากกว่า Stock!');
            $(this).val(allParts);

//        } else if ((parseInt($(this).val(), 10) > $("#qty_old-" + nId).val()) && (parseInt($(this).val(), 10) > $("#parts_nMax-" + nId).val())) {
//            alert('กรอกจำนวนมากกว่าของเดิม!');
//            $(this).val($("#qty_old-" + nId).val());

        }
        $("#parts_sum_price-" + nId).val(sumPrice.toFixed(2));

        //alert('nId :=' + nId);
        arrPartsItems[nId].parts_qty = $(this).val();
        arrPartsItems[nId].parts_sum_price = sumPrice.toFixed(2);

        if (arrPartsItems[nId].manage !== 'new') {
            arrPartsItems[nId].manage = 'edit';
            arrPartsItems[nId].parts_modified = modified_user;
        }
        sumPriceParts();
        showTablePartsItemsData(arrPartsItems);
        //alert(arrPartsItems[nId].parts_qty);
        $("#arrParts").val(JSON.stringify(arrPartsItems));
        return false;
    });

    function chkNumber(ele) {
        //check if value is pure number?
        var eleval = ele.val();

        if (isNaN(eleval)) {
            alert("ผิดพลาด! ข้อมูลที่ป้อนเข้าไปไม่ใช่ตัวเลข");
            return false;
        } else if (eleval === '') {
            alert("ค่าว่าง");
            ele.val(0);
        }
        return true;
    }

    $('#select_jobsManagement_data').on('change', 'input[id^="jobs_unit_price-"]', function() {

        var nId = $(this).attr('id').substring(16);
        var sumPrice = parseFloat($("#jobs_qty-" + nId).val() * parseFloat($(this).val()));
        $("#jobs_sum_price-" + nId).text(formatCurrency(sumPrice.toFixed(2)));
        arrJobsItems[nId].jobs_unit_price = $(this).val();
        arrJobsItems[nId].jobs_sum_price = sumPrice.toFixed(2);
        if (arrJobsItems[nId].manage !== 'new') {
            arrJobsItems[nId].manage = 'edit';
            arrJobsItems[nId].jobs_modified = modified_user;
        }
        sumPriceJobs();
        //      showTableJobsItemsData(arrJobsItems);
        $("#arrJobs").val(JSON.stringify(arrJobsItems));
        return false;
    });

    $('#select_jobsManagement_data').on('change', 'input[id^="jobs_qty-"]', function() {

        var nId = $(this).attr('id').substring(9);
        var sumPrice = parseFloat($("#jobs_unit_price-" + nId).val() * parseFloat($(this).val()));    //parseInt
        $("#jobs_sum_price-" + nId).text(formatCurrency(sumPrice.toFixed(2)));
        arrJobsItems[nId].jobs_qty = $(this).val();
        arrJobsItems[nId].jobs_sum_price = sumPrice.toFixed(2);
        if (arrJobsItems[nId].manage !== 'new') {
            arrJobsItems[nId].manage = 'edit';
            arrJobsItems[nId].jobs_modified = modified_user;
        }
        sumPriceJobs();
        $("#arrJobs").val(JSON.stringify(arrJobsItems));
        return false;
    });


    $('#select_jobsManagement_data').on('change', 'input[id^="jobs_date-"]', function() {

        var nId = $(this).attr('id').substring(10);
        arrJobsItems[nId].jobs_date = $(this).val();
        if (arrJobsItems[nId].manage !== 'new') {
            arrJobsItems[nId].manage = 'edit';
            arrJobsItems[nId].jobs_modified = modified_user;
        }
        return false;
    });


    $('#select_partManagement_data').on('change', 'input[id^="parts_date-"]', function() {

        var nId = $(this).attr('id').substring(11);
        arrPartsItems[nId].parts_date = $(this).val();
        if (arrPartsItems[nId].manage !== 'new') {
            arrPartsItems[nId].manage = 'edit';
            arrPartsItems[nId].parts_modified = modified_user;
        }
        return false;
    });


    $('#show_store_type_id').on('change', function() {
        $('#store_type_id').val(this.value);
        $('.cls-parts').empty();
        if (this.value > 0) {
            callDataParts(this.value, $('#choose_search_parts').val());
        } else {
            callDataParts('', $('#choose_search_parts').val());
        }
        var keeping = this.options[this.selectedIndex].getAttribute('data-store-type');
        var typeCount = this.options[this.selectedIndex].getAttribute('data-type-count');
        if (keeping === 'serial') {
            $('#store_max_count').val(1);
            $('#div_serial_number').show();
            $('#div_store_max_count').hide();
        } else if (keeping === 'value') {
            $('#serial_number').val("");
            $('#div_serial_number').hide();
            $('#div_store_max_count').show();
            $('#store_type_count').text(typeCount);
        }
    });


    $('#btn_submit_jobpart').on('click', function() {
        if (confirm("คุณต้องการบันทึกข้อมูล!\n กดปุ่ม OK หรือ Cancel.")) {
            $.post('parts_items/xhrInsertPart', {'arrJobs': arrJobsItems, 'arrParts': arrPartsItems}, function(o) {
                if (o.resultUpdateJobsParts === true) {
//                    alert('บันทึกข้อมูลเรียบร้อย');
                    $('.cls-partsManage').empty();
                    $('.cls-jobsManage').empty();

                    callDataJobsItems(service_id, perPage_Jobs);
                    callDataPartsItems(service_id, perPage_Parts);
                    $('.close').click();
                } else {
                    alert("บันทึกข้อมูลไม่สำเร็จ");
                }

            }, 'json');
        } else {
            return false;
            exit();
        }
        return false;
    });

    $('#btn_reset_jobpart').on('click', function() {

        $('.cls-partsManage').empty();
        $('.cls-jobsManage').empty();

        callDataJobsItems(service_id, perPage_Jobs);
        callDataPartsItems(service_id, perPage_Parts);
    });

});