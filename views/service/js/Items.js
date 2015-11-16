$(function() {
    /*
     * Start CallDataItems  *---------------------------------------------//
     * Button [Choose Items]
     * Show Value table in Dialog(model)
     */
    var txtSearch = '';
    var perPage_Items = 5;
    var visiblePages_Items = 5;
    var delay = 1000; //1 seconds
    var timer; 
    $('#div_service_cause_text,#div_service_kpi3day_text').hide();

    function callDataItems(depart_id, hardware_id, search) {

        $.post('service/Pagination/items', {'depart_id': depart_id, 'hardware_id': decodeURIComponent(hardware_id), 'search': search, 'perPage': perPage_Items}, function(o) {
            $('.pagin-items').empty();
            if (o.allPage > 1) {
                $('.pagin-items').append('<ul id="pagination-items" class="pagination-sm"></ul>');
                $('#pagination-items').twbsPagination({
                    totalPages: o.allPage,
                    visiblePages: visiblePages_Items,
                    onPageClick: function(event, page) {
                        $('.cls-items').empty();
                        callGetItemsData(depart_id, decodeURIComponent(hardware_id), search, page);
                        return false;
                    }
                });
            }
            callGetItemsData(depart_id, decodeURIComponent(hardware_id), search, 1);
        }, 'json');

    }

    function callGetItemsData(depart_id, hardware_id, search, curPage) {
        $.get('service/getItems', {'depart_id': depart_id, 'hardware_id': decodeURIComponent(hardware_id), 'search': search, 'perPage': perPage_Items, 'curPage': curPage, 'check_distribute': 'True'}, function(o) {
            for (var i = 0; i < o.length; i++) {
                if (o[i].expire === '1') {
                    danger = 'warning';
                } else {
                    danger = '';
                }
                $('#select_items_data').append('<tr class="cls-items ' + danger + ' choose-items" onmouseover="this.style.cursor=\'pointer\'"'
                        + ' rel="' + o[i].items_id + '" data-hardware_id="' + o[i].hardware_id + '" data-hardware_type_id="' + o[i].hardware_type_id + '" data-items_name="' + o[i].brand + ' ' + o[i].model + '" data-items_code="' + o[i].items_code + '" data-sn_scph="' + o[i].sn_scph + ' ' + o[i].items_depart_name + '">'
                        + '<td>' + o[i].items_id + '</td>'
                        + '<td>' + o[i].items_code + '</td>'
                        + '<td>' + o[i].sn_scph + '</td>'
                        + '<td>' + o[i].depart_name + '</td>'
                        + '<td>' + o[i].hardware_name + '</td>'
                        + '<td>' + o[i].brand + ' ' + o[i].model + '</td>'
                        + '<td align="center">' + o[i].buydate + '</td>'
                        + '<td align="center">' + o[i].expdate + '</td>'
//                        + '<td align="center"><a class="choose-items" rel="' + o[i].items_id + '" data-hardware_id="' + o[i].hardware_id + '" data-hardware_type_id="' + o[i].hardware_type_id + '" data-items_name="' + o[i].brand + ' ' + o[i].model + '" data-sn_scph="' + o[i].sn_scph + ' ' + o[i].items_depart_name + '" '
//                        + '"><a href="#">Choose</a></td>'
                        + '</tr>'
                        );
            }
        }, 'json');
    }

    /* when chossing Items "CHOOSE" in table list */
    $('#select_items_data').on('click', '.choose-items', function() {
        $('#items_code').val($(this).attr('data-items_code'));
        $('#sn_scph').val($(this).attr('data-sn_scph'));
        $('#items_name').val($(this).attr('data-items_name'));
        $('#items_id').val($(this).attr('rel'));
        $('#hardware_id').val($(this).attr('data-hardware_id'));
        $('#hardware_type_id').val($(this).attr('data-hardware_type_id'));
        $('.frm-choose-items').modal("toggle");
        $('#div_service_symptom,#div_service_symptom_text,#div_service_user').show();
        getItemSymptom($(this).attr('data-hardware_type_id'));
    });

    /* Select items in new modal */

    $('#choose-items').on('click', function() {
        $('#choose_hardware_type_id').val(0);
        $('#choose_hardware_id').val(0);
        $('#choose_search_items').val('');
        $('#choose_hardware_id').attr('disabled', 'disabled');
        $('.cls-items').empty();
        $('.pagin-items').empty();
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

    $('#choose_hardware_type_id').on('change', function() {
        $('.cls-items').empty();
        $('#choose_hardware_id').val('0');
        $('#choose_hardware_id').empty();
        if (this.value === '0') {
            $('#choose_hardware_id').attr('disabled', 'disabled');
        } else {
            $('#choose_hardware_id').removeAttr('disabled');
            $.post('service/getHardware', {'hardware_type_id': this.value}, function(o) {
                hw_id = '0';
                $('#choose_hardware_id').empty();
                $('#choose_hardware_id').append('<option value="0" selected>--ทั้งหมด--</option>');
                for (var i = 0; i < o.length; i++) {
                    hw_id += ',' + o[i].hardware_id;
                    $('#choose_hardware_id').append('<option value="' + o[i].hardware_id + '">' + o[i].hardware_name + '</option>');
                }
                callDataItems(0, hw_id, $('#choose_search_items').val());
            }, 'json');
        }
    });

    $('#choose_hardware_id').on('change', function() {
        $('.cls-items').empty();
        if ($('#choose_hardware_id').val() === undefined || $('#choose_hardware_id').val() === null || $('#choose_hardware_id').val() === '0') {
            $.post('service/getHardware', {'hardware_type_id': $('#choose_hardware_type_id').val()}, function(o) {
                hw_id = '0';
                for (var i = 0; i < o.length; i++) {
                    hw_id += ',' + o[i].hardware_id;
                }
                callDataItems(0, hw_id, $('#choose_search_items').val());
            }, 'json');
        } else {
            callDataItems(0, $('#choose_hardware_id').val(), $('#choose_search_items').val());
        }
    });

    $('#choose_search_items').on('keyup', function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            txtSearch = $('#choose_search_items').val();
            $('.cls-items').empty();
            if ($('#choose_hardware_type_id').val() === '0') {
                callDataItems(0, 0, txtSearch);
            } else {
                if ($('#choose_hardware_id').val() === undefined || $('#choose_hardware_id').val() === null || $('#choose_hardware_id').val() === '0') {
                    $.post('service/getHardware', {'hardware_type_id': $('#choose_hardware_type_id').val()}, function(o) {
                        hw_id = '0';
                        for (var i = 0; i < o.length; i++) {
                            hw_id += ',' + o[i].hardware_id;
                        }
                        callDataItems(0, hw_id, $('#choose_search_items').val());
                    }, 'json');
                } else {
                    callDataItems(0, $('#choose_hardware_id').val(), txtSearch);
                }
            }
        }, delay);

    });

    $("input[name='service_kpi3day']").on('change', function() {
        if ($(this).val() === 'fail') {
            $('#div_service_kpi3day_text').show();
        } else {
            $('#div_service_kpi3day_text').hide();
        }
    });

    $('#service_cause').on('change', function() {
        if ($(this).val() === '3') {
            $('#div_service_cause_text').show();
        } else {
            $('#div_service_cause_text').hide();
        }
    });

    /*
     * End CallDataItems *---------------------------------------------//
     */
});