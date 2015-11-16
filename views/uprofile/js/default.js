$(function() {
    
    var pid = $("#person_id").val();
    callGetPersonDataById(pid);
    
    function callGetPersonDataById(person_id) {
        if (person_id > 0) {
            $.post('uprofile/getPersonById', {'person_id': person_id}, function(o) {
                $('#person_prefix').val(o[0].prefixID);
                $('#person_fname').val(o[0].firstname);
                $('#person_lname').val(o[0].lastname);
//                $('#person_photo').val(o[0].photo);
                $('#person_office').val(o[0].officeID);
                $('#person_position').val(o[0].positionID);
                
                setPhoto(o[0].photo);
                
                
                //re-render 
                $('#person_prefix,#person_office,#person_position').selectpicker('render');
            }, 'json');
        } else {
            return false;
        }
    }  
    
    function setPhoto(photoID){
                
//        var imgUrl = 'uprofile/getImage/1100200430600';
        var imgUrl = 'http://192.168.2.250/p4p/images/PhotoPersonal/' + photoID;
        var img = $("#person_photo");

        img.html('').append('<img class="img-responsive" src="' + imgUrl + '" style="display:block; margin:auto;" />');
        
//        var imgUrl = './public/images/' + photoID;
//        var img = $("#person_photo");
//        $.ajax({
//            type: 'HEAD',
//            url: imgUrl,
//            success: function () {
//                img.html('').append('<img class="img-responsive" src="' + imgUrl + '" style="display:block; margin:auto;" />');
//                resizeImg();
//
//            },
//            error: function () {
//                img.html('').append('<img class="img-responsive" src="./public/images/fb-no-profile-picture-icon-620x389.jpg" style="display:block; margin:auto;" />');
//            }
//        });
       
    }
    
    
    
    function resizeImg() {
        $('#person_photo img').each(function () {
            $(this).load(function () {
                var maxWidth = 263; // Max width for the image
                var maxHeight = 200;   // Max height for the image
                $(this).css("width", "auto").css("height", "auto"); // Remove existing CSS
                $(this).removeAttr("width").removeAttr("height"); // Remove HTML attributes
                var width = $(this).width();    // Current image width
                var height = $(this).height();  // Current image height

                if (width > height) {
                    // Check if the current width is larger than the max
                    if (width > maxWidth) {
                        var ratio = maxWidth / width;   // get ratio for scaling image
                        $(this).css("width", maxWidth); // Set new width
                        $(this).css("height", height * ratio);  // Scale height based on ratio
                        height = height * ratio;    // Reset height to match scaled image
                    }
                } else {
                    // Check if current height is larger than max
                    if (height > maxHeight) {
                        var ratio = maxHeight / height; // get ratio for scaling image
                        $(this).css("height", maxHeight);   // Set new height
                        $(this).css("width", width * ratio);    // Scale width based on ratio
                        width = width * ratio;  // Reset width to match scaled image
                    }
                }
            });
        });
    }
    
//    function callPosition(){
//        $.post('uprofile/getPosition', {'person_id': person_id}, function (o) {
//                $('#person_position').val(o[0].position_id);
//                $('#person_fname').val(o[0].position_name);
//            }, 'json');
//    } 
    
    

/*-- Button --*/
$("#imgupload").fileinput({
    overwriteInitial: true,
    uploadUrl:"views/uprofile/uploadPic.php"+"?id_edit="+$("#person_id").val(),
    uploadAsync: true,
    allowedFileExtensions: ['jpg','png','gif','jpeg','bmp'],
    maxFileSize:1000, //kb
    maxFileCount:1, //kb
    autoReplace: true,
    previewFileType: "image",
//    browseClass: "btn btn-primary btn-block",
//    browseLabel: "เลือกรูปภาพใหม่",
//    //browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
//    //removeClass: "btn btn-danger",
    browseIcon: '<i class="glyphicon glyphicon-picture"></i>',
    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
    showCaption:false,
//    showRemove:false,
//    showUpload:false,
    msgInvalidFileExtension: 'Invalid extension for file "{name}". Only "{extensions}" files are supported.'
});
    
    /*==============================
     * Form validation & Submit
     ===============================*/
    $("#frm-uprofile").validate({
        rules: {
            person_username: {required: true},
            person_fname: {required: true},
            person_lname: {required: true}
        },
        messages: {
            person_username: {required: "Username is required!"},
            person_fname: {required: "Firstname is required!"},
            person_lname: {required: "Lastname is required!"}
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
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var url = $(form).attr('action');
            var data = $(form).serialize();
            
            $.post(url, data, function(o) {
                
                //$(".cls").empty();
                //clearForm();
                callGetPersonDataById(pid);

            }, 'json');

            return false;
        }
    });
    

});

