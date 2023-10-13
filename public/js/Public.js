const notifToast = (title, message, className) => {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "slideUp"
    }
    
    switch(className){
        case "success":
            toastr.success(message, title);
        break;

        case "info":
            toastr.info(message, title);
        break;

        case "warning":
            toastr.warning(message, title);
        break;

        case "error":
            toastr.error(message, title);
        break;
    }
}

var countdownTimer;
const emailVerification = (email, redirectPage) => {
    return Swal.fire({
        title: 'Verify your email',
        html: '<p class="mb-2"><b>'+email+'</b></p><p class="mb-0 text-monospace verify-message">Please enter OTP.</p>',
        confirmButtonText: 'Verify',
        allowOutsideClick: false,
        allowEscapeKey: false,
        input: 'text',
        inputPlaceholder: 'OTP',
        confirmButtonColor: "#28a745",
        footer:"<p class='text-monospace m-0 mt-2'>Didn't receive OTP? <a href='' class='verify-timer font-weight-bolder'>2:00</a></p>",
        willOpen: (e) => {
            $(".swal2-input").addClass("mt-2 mb-0 inputOTP");
            $(".swal2-actions").addClass("mt-2 mb-2 w-50");
            $(".swal2-confirm").addClass("font-weight-bolder btn btn-block");
            $(".swal2-footer").addClass("mt-0 mb-0 p-0");

            let verifyTimer = 120;
            const updateTimer = () => {
                const minutes = Math.floor(verifyTimer / 60);
                const seconds = verifyTimer % 60;
                $(".verify-timer").text(`${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`);
            }

            countdownTimer = setInterval(() => {
                if(verifyTimer > 0){
                    verifyTimer--;
                    updateTimer();
                }else{
                    $(".verify-timer").text("Resend");
                }
            }, 1000);
            
            $(".verify-timer").click((e) => {
                e.preventDefault();
                if($(".verify-timer").text() == "Resend"){
                    $.ajax({
                        type:"POST",
                        url:"api/v1/email/resendOTP",
                        data: {
                            email: email,
                        },
                        success: (res, textStatus, xhr) => {
                            let title = "OTP";
                            if(xhr.status == 200){
                                notifToast(title, res.message,"success");
                                verifyTimer = 120;
                            }else{
                                notifToast(title, res.message,"error");
                            }
                            $(".inputOTP").focus(); 
                        }
                    });
                }
            });
        },
        preConfirm: (result) => {
            if(result){
                let swalState = true;
                $.ajax({
                    type:"POST",
                    url:"api/v1/email/verify",
                    async: false,
                    data: {
                        email: email,
                        otp: result,
                    },
                    success: (res, textStatus, xhr) => {
                        let title = "OTP";
                        if(xhr.status == 200){
                            notifToast(title, res.message,"success");
                            switch(redirectPage){
                                case "login":
                                    window.location.href = "/";
                                break;
                            }
                            
                        }else{
                            notifToast(title, res.message,"error");
                            $(".inputOTP").val("");
                            $(".inputOTP").focus();
                            swalState = false;
                        }
                    }
                });
                return swalState;
            }else{
                notifToast("", "Invalid OTP.","error");
                $(".inputOTP").focus();
                return false;
            }
        }
    }).then((result) => {
        clearInterval(countdownTimer);
        return result;
    });
}

const findEmail = () => {
    let title = "Find your account";
    return Swal.fire({
        title: title,
        html: '<p class="mb-0 text-monospace verify-message">Please enter your email to search for your account.</p>',
        confirmButtonText: 'Search',
        confirmButtonColor: "#28a745",
        input: 'text',
        inputPlaceholder: 'Enter your email address',
        showCancelButton: true,
        willOpen: (e) => {
            $("#swal2-html-container").addClass("mt-3 mr-1 ml-1");
            $(".swal2-input").addClass("mt-2 mr-1 ml-1 inputEmail");
            $(".swal2-actions").addClass("w-100").css("justify-content","flex-end");
        },
        preConfirm: (result) => {
            if(result){
                let swalState = true;
                $.ajax({
                    type:"POST",
                    url:"api/v1/email/search",
                    async: false,
                    data: {
                        email: result,
                    },
                    success: (res, textStatus, xhr) => {
                        if(xhr.status != 200){
                            notifToast(title, res.message,"error");
                            $(".inputEmail").val("");
                            $(".inputEmail").focus();
                            swalState = false;
                        }else{
                            $.ajax({
                                type:"POST",
                                url:"api/v1/email/resendOTP",
                                data: {
                                    email: result,
                                }
                            });
                        }
                    }
                });

                if(swalState){
                   return result;
                }else{
                    return swalState;
                }

            }else{
                notifToast(title, "Invalid Email.","error");
                $(".inputEmail").focus();
                return false;
            }
        }
    }).then((result) => {
        let email = "";
        if(result.isConfirmed){
            email = result.value;
        }
        return email;
    });
}