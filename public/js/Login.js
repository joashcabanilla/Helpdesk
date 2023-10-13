$("#registerForm").submit(e => {
    e.preventDefault();
    let data = $(e.target).serializeArray();

    data.push({
        name: "action",
        value: "form",
    });

    $.ajax({
        type:"POST",
        url:"api/v1/register",
        data: data,
        success:(res) => { 
           if(res.status == "success"){
                $(".error-email",".error-username",".error-password",".error-confirmpass").css("display","none");
                emailVerification(res.email, "login");
           }else{
                for(let [key, value] of Object.entries(res.error)) {
                    let id = "error-"+key;
                    $(`.${id}`).text(value);
                    $(`.${id}`).css("display","block");
                }
           }
        }
    });
});

$("#terms").click(e => {
    e.preventDefault();
    $("#termsModal").modal("show");
});

$("#agreeTerms").change(e => {
    if($(e.target).is(":checked")){
        $("#termsModal").modal("show");
    }
});

const signUpFormkeys = {
    keys: ["#email","#username","#password","#password_confirmation"],
    class:[".error-email",".error-username",".error-password",".error-confirmpass"]
};

signUpFormkeys.keys.forEach((value,index) => {
    $(`${value}`).keypress((e) => {
        $(`${signUpFormkeys.class[index]}`).css("display","none");
    });
});

$("#forgotPassword").click((e) => {
    e.preventDefault();
    let email = findEmail();
    email.then((emailValue) => {
        if(emailValue != ""){
            let verified = emailVerification(emailValue, "forgotpassword");
            verified.then((result) => {
               if(result.value){
                    $("#updateEmail").val(emailValue);
                    $("#updateLoginModal").modal("show");
               }
            });
        }
    });
});

$('#updateLoginModal').on('shown.bs.modal', function (event) {
    $("#updateUsername,#updatePassword,#updateConfirmPassword").val("");
    $(".error-updateUsername,.error-updatePassword,.error-updateConfirmPassword").css("display","none");
    setTimeout(() => {
        $("#updateUsername").focus();
    },1000);
});

$("#updateLoginForm").submit(e => {
    e.preventDefault();
    let data = $(e.target).serializeArray();
    $.ajax({
        type:"POST",
        url:"api/v1/email/update/credentials",
        data: data,
        success:(res, textStatus, xhr) => { 
            let title = "Login Credentials";
            if(xhr.status == 200){
                notifToast(title, res.message,"success");
                $('#updateLoginModal').modal("hide");
            }else{
                notifToast(title, res.message,"error");
                for(let [key, value] of Object.entries(res.error)) {
                    let id = "error-update"+key.replace(key[0],key[0].toUpperCase());
                    $(`.${id}`).text(value);
                    $(`.${id}`).css("display","block");
                }
            }
        }
    });
});

const logincredentialFormkeys = {
    keys: ["#updateUsername","#updatePassword","#updateConfirmPassword"],
    class:[".error-updateUsername",".error-updatePassword",".error-updateConfirmPassword"]
};

logincredentialFormkeys.keys.forEach((value,index) => {
    $(`${value}`).keypress((e) => {
        $(`${logincredentialFormkeys.class[index]}`).css("display","none");
    });
});