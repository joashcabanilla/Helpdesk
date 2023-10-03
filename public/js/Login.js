$("#registerForm").submit(e => {
    e.preventDefault();
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