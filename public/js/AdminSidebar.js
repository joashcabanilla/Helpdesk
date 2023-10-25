const changeCategory = (subjectElement, data) => {
    $(subjectElement).val("");
    $(subjectElement).empty().trigger('change');

    let subjectDataRequest = fetchAPI(localStorage.getItem("api_token"),"api/v3/get/data/subject/0",data);
    subjectDataRequest.then((response) => {
        if(response.ok){
            return response.json();
        }else{
            notifToast("Ticket Board Tab", "DATA ERROR","error");
        }
    }).then((data) => {
        if(data.length != 0){
            if(subjectElement == "#subject"){
                $(subjectElement).append("<option value=''></option>");
            }
            select2GenerateData(data,subjectElement);
            $(subjectElement).attr("disabled",false);
        }else{
            $(subjectElement).attr("disabled",true);
        }
    });
}
const newticketTab = () => {
    $(".tabTitle").text("NEW TICKET");
    $("#backBtn").html("<i class='fas fa-arrow-left'></i> Return to ticket board");
    $("#backBtn").attr("href",routeTicketBoard);

    $("#backBtn").click((e) => {
        e.preventDefault();
        let url = $(e.currentTarget).attr("href");
        $(".content").load(url, ( res, status, xhr) => {
            if(status == "success"){
                ticketBoardTab();
            }else{
                notifToast("Admin Page", "PAGE NOT FOUND","error");
            }
        });
    });

    let categoryDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/category/0");
    categoryDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#category","#select2-category-container");
        }else{
            notifToast("Ticket Board Tab", "DATA ERROR","error");
        }
    });

    let subjectDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/subject/0");
    subjectDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#subject","#select2-subject-container");
        }else{
            notifToast("Ticket Board Tab", "DATA ERROR","error");
        }
    });

    $("#category").change((e) => {
        let data = {
            category: [$(e.currentTarget).val()]
        };
        changeCategory("#subject",data);
    });
}

const ticketBoardTab = () => {
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    let categoryDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/category/0");
    let branchDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/branch/0");
    let departmentDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/department/0");

    categoryDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#categoryFilter");
        }else{
            notifToast("Ticket Board Tab", "DATA ERROR","error");
        }
    });

    branchDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#branchFilter");
        }else{
            notifToast("Ticket Board Tab", "DATA ERROR","error");
        }
    });

    departmentDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#departmentFilter");
        }else{
            notifToast("Ticket Board Tab", "DATA ERROR","error");
        }
    });

    $("#categoryFilter").change((e) => {
        let data = {
            category: $(e.currentTarget).val()
        };
        changeCategory("#subjectFilter",data);
    });

    $("#newTicketBtn").click((e) => {
        let url = $(e.currentTarget).data("url");
        $(".content").load(url, ( res, status, xhr) => {
            if(status == "success"){
                newticketTab();
            }else{
                notifToast("Admin Page", "PAGE NOT FOUND","error");
            }
        });
    });
}

$(document).ready((e) => {
    ticketBoardTab();
});

$(".tabLink").click((e) => {
   let url = $(e.currentTarget).attr("href");
   let tab = $(e.currentTarget).find("p").text(); 
   $(".content").load(url, ( res, status, xhr) => {
        if(status == "success"){
            $(".tabTitle").text(tab.toUpperCase());
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