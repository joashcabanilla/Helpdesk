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