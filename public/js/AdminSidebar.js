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
            select2GenerateData(data,subjectElement, "#select2-subject-container");
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
    
    $("#attachAdd").click((e) => {
        e.preventDefault();
        let attachmentCtr = 0;
        let filenameArray = [];
        $(".attachmentInput input").each((index,element) => {
            if(element.value == ""){
                $(element).remove();
            }else{
                attachmentCtr++;
                filenameArray.push(element.files[0].name);
            }
        });

        if(attachmentCtr < 3){
            let attachmentInput = $("<input type='file' name='attachImage[]' accept='image/jpeg, image/png, image/jpg'>");

            attachmentInput.change((e) => {
                let file = e.currentTarget.files[0];
                let type = file.type.split("/");
                if(type[1] == "jpeg" || type[1] == "png" || type[1] == "jpg"){
                    let fileSize = file.size / (1024 * 1024);
                    if(fileSize > 10){
                        notifToast("Attachment",`Invalid file size ${file.name} ${Math.trunc(fileSize*100)/100}MB.Maximum allowed file size is 10MB. Only files with the following extensions are allowed: png, jpeg`,"error");
                        $(e.currentTarget).remove();
                    }else{
                        let filenameExist = filenameArray.find(element => element === file.name);

                        if(filenameExist != undefined){
                            notifToast("Attachment","File already exist.","error");
                            $(e.currentTarget).remove();
                        }else{
                            let reader = new FileReader();

                            reader.onload = (data) => {

                                let filenameElement = $("<a class='btn btn-sm btn-light attachFilename'>"+file.name+" <i class='far fa-times-circle text-danger'></i></a>");

                                let imageElement = $("<div class='col-lg-2 col-md-3 col-sm-12 p-1'><div class='img-fluid elevation-2 carouselImage'><img class='carouselSetImage' alt='attachment image'  width='100' height='100' src='"+data.target.result+"'/></div></div>");
                                
                                let attachmentGallery = $("<div data-toggle='lightbox' data-gallery='hidden-images' data-remote='"+data.target.result+"' data-title='"+file.name+"'></div>");
                                
                                $(".attachLabel").text("Attachments ("+$(".attachmentInput").children().length+")");

                                filenameElement.click((e) => {
                                    e.preventDefault();
                                    attachmentInput.remove();
                                    imageElement.remove();
                                    attachmentGallery.remove();
                                    $(e.currentTarget).remove();
                                    $(".attachLabel").text("Attachments ("+$(".attachmentInput").children().length+")");
                                });

                                imageElement.find("img").click((e) => {
                                    e.preventDefault();
                                    $(attachmentGallery).ekkoLightbox();
                                });

                                if(attachmentCtr < 1){
                                    $(".attachLabel").after(filenameElement);
                                }else{
                                    $('.attachFilename:last').after(filenameElement);
                                }
                                $(".attachmentContainer").append(imageElement).append(attachmentGallery);
                                
                            }
                            reader.readAsDataURL(file);
                        }
                    }
                }else{
                    $(e.currentTarget).remove();
                    notifToast("Attachment",`Invalid file type ${file.name}.`,"error");
                }
            });
            $(".attachmentInput").append(attachmentInput);
            $(attachmentInput).click();
        }else{
            notifToast("Attachment","You can only attach 3 images.","warning"); 
        }
    });

    $("#attachDelete").click((e) => {
        e.preventDefault();
        $(".attachmentInput").empty();
        $(".attachmentContainer").empty();
        $(".attachLabel").parent().find("a:not(.addDelete)").remove();
        $(".attachLabel").text("Attachments (0)");
    });

    $('#description').summernote({
        placeholder: 'Description',
        tabsize: 2,
        height: 200,     
        dialogsInBody:true,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['table', []],
            ['insert', []],
            ['view', []],
            ['help', ['help']]
        ]
    });

    $("#newTicketform").submit((e) => {
        e.preventDefault();
        let formData = new FormData(e.currentTarget);
        let description = $("#description").val();
        
        if(description == "" || description == "<p><br></p>" || description == "&nbsp;" || description == "<p>&nbsp;</p>"){
            $('#description').summernote('focus');
            notifToast("New Ticket","Please fill out description","warning");
        }else if($("#subject").attr("disabled")){
            notifToast("New Ticket","Please select subject","warning");
        }
        else{
            formData.set("description",$('#description').summernote('code'));
            let createTicket = ajaxPostFile(localStorage.getItem("api_token"),"api/v3/ticket/create",formData);
            createTicket.done((res, textStatus, xhr) => {
                if(xhr.status == 200){
                    notifToast("New Ticket",res,"success");
                }else{
                    notifToast("New Ticket",res,"error");
                }
                $("#category").val("").trigger("change").focus();
                $('#description').summernote('code', '');
                $("#attachDelete").trigger("click");
            });
        }
    });
}

const ticketBoardTab = () => {
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
    let api_token = localStorage.getItem("api_token");
    let categoryDataRequest = ajaxPostRequest(api_token,"api/v3/get/data/category/0");
    let branchDataRequest = ajaxPostRequest(api_token,"api/v3/get/data/branch/0");
    let departmentDataRequest = ajaxPostRequest(api_token,"api/v3/get/data/department/0");
    generateTicketComponent();

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

    $("#clearFilter").click((e) => {
        e.preventDefault();
        $(".tabLink.active").trigger("click");
    });

    $("#branchFilter,#departmentFilter,#categoryFilter,#subjectFilter,#levelFilter,#datefromFilter,#datetoFilter").change((e) => {
        e.preventDefault();
        let data = {
            branch: $("#branchFilter").val(),
            department: $("#departmentFilter").val(),
            category: $("#categoryFilter").val(),
            subject: $("#subjectFilter").val(),
            level: $("#levelFilter").val(),
            datefrom: $("#datefromFilter").val(),
            dateto: $("#datetoFilter").val(),
        };
        
        if($(e.currentTarget).attr("id") != "categoryFilter"){
            generateTicketComponent(data);
        }
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