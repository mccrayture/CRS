$(function() {
        $("#select_service_data").on("click", ".state", function () {
            //--State Dialog--
                $('.frm-choose-state').modal("toggle");
                var service_id = $(this).attr('rel');
                var status_id = $(this).attr('data-state-id');
                $('.frm-choose-state #service_id').val(service_id);
                $.post('service/getServiceDetailStatus', function(o) {
                    $('#choose_service_detail_status_id').empty();
                    for (var i = 0; i < o.length; i++) {
                        if (status_id === o[i].status_id) {
                            $('#choose_service_detail_status_id').append('<option value="' + o[i].status_id + '" selected>' + o[i].status_name + '</option>');
                        } else {
                            $('#choose_service_detail_status_id').append('<option value="' + o[i].status_id + '">' + o[i].status_name + '</option>');
                        }
                    }
                }, 'json');
        });

        /*-- State change submit --*/
        $('#btn_submit_change_state').on('click', function () {
            submitChangeState();
        });

        function submitChangeState() {
            var service_id = $('.frm-choose-state #service_id').val();
            var status_id = $('.frm-choose-state #status_id').val();
            
            var updateTime = now();
            var updateUser = $("#userPerson_id").val();
            
            
            
            var data_up_state = {
                    'service_detail_status_id' : service_id,
                    'service_detail_datetime' : updateTime,
                    'service_detail_user' : updateUser
                };
            
            var data_insert_detail = {
                    'service_detail_datetime' : updateTime,
                    'userPerson_id' : updateUser,
                };

            if (service_id !== "" && status_id !== "")
            {
                $.post('service/xhrUpdateState', data_up_state, function (o) {
                    
                    
                    
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
                
                
                
            }
            return false;

        }
});
/*-------------------------*/