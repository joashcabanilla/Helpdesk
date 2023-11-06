$(".tabLink").click((e) => {
    e.preventDefault();
    
    $(".tabLink").removeClass("active font-weight-bold");
    $(e.currentTarget).addClass("active font-weight-bold");
    
    if($(e.currentTarget).parent().parent().hasClass("nav-treeview")){
        let currentDropdownTab = $(e.currentTarget).parent().parent();
        let currentDropdownMainTab = $(currentDropdownTab).parent();
        let currentDropdownMainMenu = $(currentDropdownTab).prev();
        $(".dropdownTab").not(currentDropdownTab).slideUp();
        $(".dropdownTab").parent().not(currentDropdownMainTab).removeClass("menu-is-opening menu-open");
        $(".dropdownTab").prev().not(currentDropdownMainMenu).removeClass("active font-weight-bold");
        $(currentDropdownMainMenu).addClass("active font-weight-bold");
    }else{
        $(".dropdownTab").prev().removeClass("active font-weight-bold");
        $(".dropdownTab").slideUp();
        $(".dropdownTab").parent().removeClass("menu-is-opening menu-open");
    }
});

$("#navSearchTicketForm").submit((e) => {
    e.preventDefault();
    let api_token = localStorage.getItem("api_token");
    let getTicket = ajaxPostRequest(api_token, "api/v3/ticket/get/0",{ticketNo: $("#navSearchTicket").val()});
    let url = $(e.currentTarget).find("button").data("url");
    
    getTicket.done((res, textStatus, xhr) => {
        if(xhr.status == 200 && res.length == 1){
            res.forEach(data => {
                $(".content").load(url, ( res, status, xhr) => {
                    if(status == "success"){
                        viewTicketTab(data);
                    }else{
                        notifToast("Admin Page", "PAGE NOT FOUND","error");
                    }
                });
            });
            $("#navSearchTicket").val("").blur();
        }else{
            notifToast("Search Ticket","Ticket Not Found","error");
        }
    });
});