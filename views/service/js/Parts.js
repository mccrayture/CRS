$(function() {
    /*
     * Start CallDataParts  *---------------------------------------------//
     * Button [Choose Parts]
     * Show Value table in Dialog(model)
     */

    //Create By Komsan 08/07/2558
    $('#show_store_type_id').on('change', function() {
        $('#store_type_id').val(this.value);
        $('.cls-parts').empty();
        callDataParts(this.value);
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

    perPage_Parts = 5;
    visiblePages_Parts = 5;
    function callDataParts(store_type_id, store_id, search) {
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
                if (o[i].expire === '1') {
                    danger = 'warning';
                } else {
                    danger = '';
                }
                $('#select_parts_data').append('<tr class="cls-parts ' + danger + '"><td>' + (i + 1) + '</td>'
                        + '<td>' + o[i].store_lotno + '</td>'
                        + '<td>' + o[i].store_type_name + '</td>'
                        + '<td>' + o[i].store_name + '</td>'
                        + '<td align="center">' + o[i].serial_number + '</td>'
                        + '<td align="center">' + o[i].store_type_count + '</td>'
                        + '<td align="center">' + o[i].store_max_count + '</td>'
                        + '<td align="center">' + o[i].store_adddate + '</td>'
                        + '<td align="center"><a class="choose-parts" rel="' + o[i].store_id + '" data-store_lotno="' + o[i].store_lotno
                        + '" data-store_type_name="' + o[i].store_type_name + '" data-store_name="' + o[i].store_name + '"'
                        + '" data-serial_number="' + o[i].serial_number + '" data-store_type_count="' + o[i].store_type_count + '"'
                        + '" data-store_max_count="' + o[i].store_max_count + '"' + '" data-store_adddate="' + o[i].store_adddate + '"'
                        + '" data-key="' + o[i].store_id + o[i].store_lotno + o[i].store_type_name + o[i].store_name + o[i].serial_number + '"'
                        + '" href="#">Choose</a></td>'
                        + '</tr>'
                        );
            }

        }, 'json');
    }

    /* when chossing Parts "CHOOSE" in table list */
    $('#select_parts_data').on('click', '.choose-parts', function() {
        //alert('choose');
        var maxRow = $('#select_partManagement_data tr').size();
        var store_max_count = "";
        if ($(this).attr('data-store_max_count') === '1') {
            store_max_count = '<td align="rgiht">' + $(this).attr('data-store_max_count') + '</td>';
            store_max_count = store_max_count + '<td align="rgiht">' + $(this).attr('data-store_max_count') + '</td>';
        } else {
            store_max_count = '<td align="right"><input type="text" id="qty-' + (maxRow + 1) + '" name="qty-' + (maxRow + 1) + '" value = "' + $(this).attr('data-store_max_count') + '"></input></td>';
            store_max_count = store_max_count + '<td align="rgiht">' + $(this).attr('data-store_max_count') + '<input type="hidden" id="nMax-' + (maxRow + 1) + '" name="nMax-' + (maxRow + 1) + '" value = "' + $(this).attr('data-store_max_count') + '"></td>';
        }

        var search = $(this).attr('data-store_name');
        var addDataInTable = '';
        //alert('search:=' + search);
        $('#select_partManagement_data td').filter(function() {

            if ($(this).text() === search) {
                alert('ถูกเลือกไปแล้ว');
                //alert('text:=' + $(this).text());
                addDataInTable = 'No';
                return true;
            } else {
                //alert('else');
                addDataInTable = 'Yes';
                //return true;
            }
        });

        alert('addDataInTable:=' + addDataInTable);
        if (addDataInTable !== 'No') {
            $('#select_partManagement_data').append('<tr class="cls-partsManage row-' + (maxRow + 1) + ' ' + danger + '"><td>' + (maxRow + 1) + '<input type="hidden" id="key" name="key" value = "' + $(this).attr('data-key') + '"></td>'
                    + '<td>' + $(this).attr('data-store_lotno') + '</td>'
                    + '<td>' + $(this).attr('data-store_type_name') + '</td>'
                    + '<td>' + $(this).attr('data-store_name') + '</td>'
                    + '<td align="center">' + $(this).attr('data-serial_number') + '</td>'
                    + '<td align="center">' + $(this).attr('data-store_type_count') + '</td>'
                    + store_max_count
                    + '<td align="center">' + $(this).attr('data-store_adddate') + '</td>'
                    + '<td align="center"><a class="del btn btn-sm btn-danger" rel="' + (maxRow + 1) + '" href="#"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>'
                    + '</tr>'
                    );
        }


        $('.frm-choose-parts').modal("toggle");
    });

    /* Select parts in new modal */
    $('#choose-parts').on('click', function() {
        $('#choose_store_type_id').val(0);
        $('#choose_store_id').val(0);
        $('#choose_search_parts').val('');
        $('#choose_parts_id').attr('disabled', 'disabled');
        $('.cls-parts').empty();
        $('.pagin-parts').empty();
    });


    $('#select_partManagement_data').on('click', '.del', function() {
        var curID = $(this).attr('rel');
        $('.row-' + curID).empty();
        return false;
    });


    $('#select_partManagement_data').on('change', 'input[id^="qty-"]', function() {
        var nMax_id = $(this).attr('id').substring(4);
        if ($(this).val() > $("#nMax-" + nMax_id).val()) {
            alert('Qty Over Max Stock!');
            $(this).val($("#nMax-" + nMax_id).val());
        }
        return false;

    });

});

