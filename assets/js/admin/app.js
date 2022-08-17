 

jQuery(document).ready(function ($) {
    

    $('#event-id-sms').on('change', function () {
        // alert( this.value + ajaxurl);
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {
                action: "nas_sms_phone_number_loader",
                event: this.value
            },
            success: function (data) {
                $('#phone-numbers').val(data);
            },
            error: function (errorThrown) {
                alert(errorThrown);
            }

        });
    });



    $('.sms-sender-form').on('submit', function (event) {
        event.preventDefault();

        var otp_data = new FormData();
        otp_data.append('action', 'nas_send_token');
        var to = $('#phone-numbers').val();
        var message = $('#message').val();
        otp_data.append('to', to);
        otp_data.append('message', message);

        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            contentType: false,
            processData: false,
            // data: {
            //     action: "nas_send_token",
            //     event: this.value
            // },
            data: otp_data,
            success: function (data) {
                $('#sms-result').css('display', 'block');
            },
            error: function (errorThrown) {
                alert(errorThrown);
            }

        });
    });


    function participate_done() {
        var $eventForm = $('#reject-form');
        var otp_data = new FormData();
        otp_data.append('action', 'nas_send_token');

        var to = $('#phone').val(),
            otp_sms = $('#message').val();
			otp_data.append('to', to);
			otp_data.append('message', otp_sms);
        
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            contentType: false,
            processData: false,
            data: otp_data,
            error: function (error) {
                alert("OTP Failed" + error);
            },
            success: function (response) {
                setTimeout(function(){
                    location.reload();
                }, 1500);
            }

        });
    }

    $('#nas-item-reject').on('click', function (e) {
        e.preventDefault();
        var $eventForm = $('#reject-form');
        var form_data = new FormData();
        form_data.append('action', 'nas_item_reject');
        form_data.append('formData', $eventForm.serialize());
        // alert( this.value + ajaxurl);
        var participator_id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    contentType: false,
					processData: false,
                    data: form_data,
                    success: function (data) {
                        if( data == 'deleted' ){
                            Swal.fire(
                                'Rejected!',
                                'Your file has been rejected.',
                                'success'
                              );
                              participate_done();
                        } else{
                            Swal.fire({
                                title: 'Something Wrong',
                                text: 'Rejected Failed.',
                                icon: 'error',
                                allowOutsideClick: false,
                                confirmButtonText: 'Ok'
                            });
                        }
                        
                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                    }
        
                });
            }
          })
        
    });


    $('.nas-add-review-rotate-btn').css('margin-top', '16px');
    $('.nas-add-review-rotate-btn').on('click', function(){
        var h=$(this).closest('.nas-review-img').find('img').height();
        var w=$(this).closest('.nas-review-img').find('img').width();
        var deg=$(this).data('deg');

        if(deg == 90){
            $(this).closest('.nas-review-img').find('.nas-review-img-wrapper').css("width","100%");
            $(this).closest('.nas-review-img').find('.nas-review-img-wrapper').css("height",""+w+"px");
            $(this).closest('.nas-review-img').find('img').css('transform', 'rotate('+deg+'deg)');
        }  
        if(deg == 180){
            $(this).closest('.nas-review-img').find('.nas-review-img-wrapper').css("width","100%");
            $(this).closest('.nas-review-img').find('.nas-review-img-wrapper').css("height","auto");
            $(this).closest('.nas-review-img').find('img').css('transform', 'rotate('+deg+'deg)');
        }
        if(deg == 270){
            $(this).closest('.nas-review-img').find('.nas-review-img-wrapper').css("width","100%");
            $(this).closest('.nas-review-img').find('.nas-review-img-wrapper').css("height",""+w+"px");
            $(this).closest('.nas-review-img').find('img').css('transform', 'rotate('+deg+'deg)');
        }  
        if(deg == 360){
            $(this).closest('.nas-review-img').find('.nas-review-img-wrapper').css("width","100%");
            $(this).closest('.nas-review-img').find('.nas-review-img-wrapper').css("height","auto");
            $(this).closest('.nas-review-img').find('img').css('transform', 'rotate('+deg+'deg)');
        }
        
    });


    function restore_done(phone, msg, participator_id) {

        var $eventForm = $('#wpbody form');
        var otp_data = new FormData();
        otp_data.append('action', 'nas_send_token');

        var to = phone,
            otp_sms = msg;
        otp_data.append('to', to);
        otp_data.append('message', otp_sms);

        $.ajax({
            url: ajaxurl,
            type: 'POST',
            contentType: false,
            processData: false,
            data: otp_data,
            error: function (error) {
                alert("OTP Failed" + error);
            },
            success: function (response) {
                setTimeout(function () {
                    $('#' + participator_id).closest('tr').hide('slow');
                }, 1000);
            }

        });
    }

    $('.nas-restore-reject').on('click', function (e) {
        e.preventDefault();
        var participator_id = $(this).attr('id');
        var phone = $(this).data('phone');
        var msg = 'Congrats, we added you to the review list again. NAS Drawing Academy';
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: ajaxurl,
                    // contentType: false,
                    // processData: false,
                    data: {
                        action: 'nas_reject_restore',
                        participatorId: participator_id,
                    },
                    success: function (data) {
                        if (data == 'restore') {
                            Swal.fire(
                                'Restored!',
                                'Your file has been restore.',
                                'success'
                            );
                            restore_done(phone, msg, participator_id);
                        } else {
                            Swal.fire({
                                title: 'Something Wrong',
                                text: 'Restore Failed.',
                                icon: 'error',
                                allowOutsideClick: false,
                                confirmButtonText: 'Ok'
                            });
                        }

                    },
                    error: function (errorThrown) {
                        alert(errorThrown);
                    }

                });
            }
        })

    });


});
