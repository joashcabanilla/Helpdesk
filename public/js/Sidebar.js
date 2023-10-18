$(".tabLink").click((e) => {
    e.preventDefault();

    let url = $(e.currentTarget).attr("href");
    let tab = $(e.currentTarget).find("p").text();

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

    $(".content").load(url, ( res, status, xhr) => {
        if(status == "success"){
            $(".tabTitle").text(tab.toUpperCase());
        }else{
            notifToast("Admin Page", "PAGE NOT FOUND","error");
        }
    });
});