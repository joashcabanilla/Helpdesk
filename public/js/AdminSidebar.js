const ticketBoardTab = () => {
    let boardDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/board/0");
    let branchDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/branch/0");
    let departmentDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/department/0");
    let subjectDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/subject/0");

    boardDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#boardFilter");
        }else{
            notifToast("Ticket Board Page", "DATA ERROR","error");
        }
    });

    branchDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#branchFilter");
        }else{
            notifToast("Ticket Board Page", "DATA ERROR","error");
        }
    });

    departmentDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#departmentFilter");
        }else{
            notifToast("Ticket Board Page", "DATA ERROR","error");
        }
    });

    subjectDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#subjectFilter");
        }else{
            notifToast("Ticket Board Page", "DATA ERROR","error");
        }
    });
}

$(document).ready((e) => {
    $('.select2bs4').css("width","100%");
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    ticketBoardTab();
});

$(".tabLink").click((e) => {
   let url = $(e.currentTarget).attr("href");
   let tab = $(e.currentTarget).find("p").text(); 
   $(".content").load(url, ( res, status, xhr) => {
        if(status == "success"){
            $(".tabTitle").text(tab.toUpperCase());
            $('.select2bs4').css("width","100%");
            //Initialize Select2 Elements
            $('.select2').select2();

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });
            switch(tab){
                case "Ticket Board":
                    ticketBoardTab();
                break;
            }
        }else{
            notifToast("Admin Page", "PAGE NOT FOUND","error");
        }
    });
});