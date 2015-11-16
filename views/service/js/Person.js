$(function() {
    /*
     * Start CallDataPerson  *---------------------------------------------//
     * Button [Choose Person]
     * Show Value table in Dialog(model)
     */

    var perPage_Person = 5;
    var visiblePages_Person = 5;
    var delay = 1000; //1 seconds
    var timer;
    function callDataPerson(search) {
        $.post('service/Pagination/technician', {'search': search, 'perPage': perPage_Person}, function(o) {
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

    //alert('In If...');
    //create by komsan 09/06/2558
//     function callGetPersonDataById(person_id) {
//        if (person_id > 0) {
//            $.post('service/getPersonById', {'person_id': person_id}, function(o) {
//                $('#service_user_name').val(o[0].prefix + o[0].firstname + ' ' + o[0].lastname);
//                $('#service_user').val(o[0].person_id);
//            }, 'json');
//        } else {
//            return false;
//        }
//    }

    function callGetPersonData(search, curPage) {
        $.get('service/getPerson', {'search': search, 'perPage': perPage_Person, 'curPage': curPage}, function(o) {
            for (var i = 0; i < o.length; i++) {
                if (o[i].expire === '1') {
                    danger = 'warning';
                } else {
                    danger = '';
                }


                $('#select_person_data').append('<tr class="cls-person ' + danger + ' choose-person" onmouseover="this.style.cursor=\'pointer\'"'
                        + ' rel="' + o[i].person_id + '" data-person_name="' + o[i].pname + o[i].fname + ' ' + o[i].lname + '" href="#">'
                        + '<td>' + o[i].person_id + '</td>'
                        + '<td>' + o[i].pname + o[i].fname + ' ' + o[i].lname + '</td>'
                        + '<td>' + o[i].office + '</td>'
                        //+ '<td align="center"><a class="choose-person" rel="' + o[i].person_id + '" data-person_name="' + o[i].pname + o[i].fname + ' ' + o[i].lname + '" href="#">Choose</a></td>'
                        + '</tr>'
                        );
            }

            $('.choose-person').on('click', function() {
                $('#service_user_name').val($(this).attr('data-person_name'));
                $('#service_user').val($(this).attr('rel'));
                $('#model-person-close.close').click();
            });
        }, 'json');
    }

    //callDataParts


    $('#choose-person').on('click', function() {
        $('.cls-person').empty();
        callDataPerson('');
    });

    //choose_search_person
    $('#choose_search_person').on('keyup', function() {

        clearTimeout(timer);
        timer = setTimeout(function() {
            $('.cls-person').empty();
            callDataPerson($('#choose_search_person').val());
        }, delay);
    });

    /*
     * End CallDataPerson
     */
});