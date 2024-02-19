const changeCategory = (subjectElement, data, editTicketValue = 0) => {
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
            if(editTicketValue != 0){
                $(subjectElement).val(editTicketValue).trigger("change");
            }
        }else{
            $(subjectElement).attr("disabled",true);
        }
    });
}

const ticketFilterComponent = (dataTable = false) => {
    let api_token = localStorage.getItem("api_token");
    let categoryDataRequest = ajaxPostRequest(api_token,"api/v3/get/data/category/0");
    let branchDataRequest = ajaxPostRequest(api_token,"api/v3/get/data/branch/0");
    let departmentDataRequest = ajaxPostRequest(api_token,"api/v3/get/data/department/0");

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

    if(!dataTable){
        $("#clearFilter").click((e) => {
            e.preventDefault();
            $(".tabLink.active").trigger("click");
        });
    }
}

const newticketTab = (data = {}) => {
    let tabTitle = "NEW TICKET";
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });
    let categoryDataRequest = ajaxPostRequest(localStorage.getItem("api_token"),"api/v3/get/data/category/0");
    categoryDataRequest.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            select2GenerateData(res,"#category","#select2-category-container");
            if(Object.keys(data).length != 0){
                $("#category").val(data.category.value).trigger("change");
                $("#priorityLevel").val(data.priorityLevel.value).trigger("change");
            }
        }else{
            notifToast("Ticket Board Tab", "DATA ERROR","error");
        }
    });
    
    $("#category").change((e) => {
        let catData = {
            category: [$(e.currentTarget).val()]
        };
        Object.keys(data).length != 0 ? changeCategory("#subject",catData, data.subject.value) : changeCategory("#subject",catData);
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

                                let filenameElement = $("<a class='btn btn-sm btn-light mr-1 attachFilename'>"+file.name+" <i class='far fa-times-circle text-danger'></i></a>");

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

    if(Object.keys(data).length != 0){
        tabTitle = "EDIT TICKET: " + data.ticketNoLabel;
        $("#createTicketBtn").text("Save Ticket");

        data.attach.forEach((image,index) => {
            if(image != null){
                let attachmentInput = $("<input type='file' name='attachImage[]' accept='image/jpeg, image/png, image/jpg'>");
                let image64 = image.replace("data:image/jpeg;base64,","");
                let byteCharacters = atob(image64);
                let byteNumbers = new Array(byteCharacters.length);
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteNumbers[i] = byteCharacters.charCodeAt(i);
                }
                let byteArray = new Uint8Array(byteNumbers);
                let blob = new Blob([byteArray], { type: "application/octet-stream" });
                index++;
                let fileName = "Attachment" + index;
                let file = new File([blob], fileName);
                let fileList = new DataTransfer();
                fileList.items.add(file);
                $(attachmentInput)[0].files = fileList.files;

                let filenameElement = $("<a class='btn btn-sm btn-light mr-1 attachFilename'>"+fileName+" <i class='far fa-times-circle text-danger'></i></a>");

                let imageElement = $("<div class='col-lg-2 col-md-3 col-sm-12 p-1'><div class='img-fluid elevation-2 carouselImage'><img class='carouselSetImage' alt='attachment image'  width='100' height='100' src='"+image+"'/></div></div>");
                                
                let attachmentGallery = $("<div data-toggle='lightbox' data-gallery='hidden-images' data-remote='"+image+"' data-title='"+fileName+"'></div>");
                
                if(index <= 1){
                    $('.attachLabel').after(filenameElement);
                }else{
                    $('.attachFilename:last').after(filenameElement);
                }
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
                $(".attachmentInput").append(attachmentInput);
                $(".attachmentContainer").append(imageElement).append(attachmentGallery);
                $(".attachLabel").text("Attachments ("+$(".attachmentInput").children().length+")");
            }
        });

        $("#description").summernote("code", data.description);
    }

    $(".tabTitle").text(tabTitle);
    $("#backBtn").html("<i class='fas fa-arrow-left'></i> Return to " + $(".tabLink.active").find("p").text().toLowerCase());

    $("#backBtn").click((e) => {
        e.preventDefault();
        $(".tabLink.active").trigger("click");
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
            if(Object.keys(data).length != 0){
                formData.set("ticketId", data.id);
                let updateTicket = ajaxPostFile(localStorage.getItem("api_token"),"api/v3/ticket/update",formData);
                updateTicket.done((res, textStatus, xhr) => {
                    if(xhr.status == 200){
                        notifToast("Edit Ticket",res,"success");
                    }else{
                        notifToast("Edit Ticket",res,"error");
                    }
                });
            }else{
                let createTicket = ajaxPostFile(localStorage.getItem("api_token"),"api/v3/ticket/create",formData);
                createTicket.done((res, textStatus, xhr) => {
                    if(xhr.status == 200){
                        notifToast("New Ticket",res,"success");
                    }else{
                        notifToast("New Ticket",res,"error");
                    }
                    $("#priorityLevel").val("").trigger("change");
                    $("#category").val("").trigger("change").focus();
                    $('#description').summernote('code', '');
                    $("#attachDelete").trigger("click");
                });
            }
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

    ticketFilterComponent();
    
    const sortableReceiveStatus = (event, ui, status, element) => {
        let ticketStatus = updateTicketStatus({
            id: $(ui.item).find(".ticketId").val(),
            status: status,
            ticketNoLabel: $(ui.item).find(".ticketNoLabel").text()
        });

        ticketStatus.done((res, textStatus, xhr) => {
            if(xhr.status != 200){
                ui.sender.sortable("cancel");
            }
        });
    }

    $(".todoContainer").sortable({
        connectWith: ".inprogressContainer",
        placeholder: 'sort-highlight-todo',
        forcePlaceholderSize: true,
        receive: function( event, ui ) {
            sortableReceiveStatus(event, ui, 1, ".todoContainer");
        }
    }).disableSelection();

    $(".inprogressContainer").sortable({
        connectWith: ".todoContainer,.doneContainer",
        placeholder: 'sort-highlight-progress',
        forcePlaceholderSize: true,
        receive: function( event, ui ) {
            sortableReceiveStatus(event, ui, 2, ".inprogressContainer");
        }
    }).disableSelection();

    $(".doneContainer").sortable({
        connectWith: ".inprogressContainer",
        placeholder: 'sort-highlight-done',
        forcePlaceholderSize: true,
        receive: function( event, ui ) {
            sortableReceiveStatus(event, ui, 3, ".doneContainer");
        }
    }).disableSelection();

    generateTicketComponent();
    
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

const ticketListTab = () => {
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
        theme: 'bootstrap4'
    });

    ticketFilterComponent(true);
    $("#clearFilter").parent().parent().find("label").remove();

    let api_token = localStorage.getItem("api_token");
    let ticketListTable = $('#ticketListTable').DataTable({
        processing: true,
        language: {          
            processing: "<p class='text-danger font-weight-bold'>Processing, Please wait...</p>",
        },
        ordering: false,
        serverSide: true,
        dom: 'rtip',
        columnDefs: [
            {targets: 0, width: '1%', className:"text-center font-weight-bold"},
            {targets: 1, width: '10%', className:"text-center font-weight-bold"},
            {targets: 2, width: '15%', className:"text-left font-weight-bold"},
            {targets: 3, width: '15%', className:"text-left font-weight-bold"},
            {targets: 4, width: '15%', className:"text-left font-weight-bold"},
            {targets: 5, width: '15%', className:"text-center font-weight-bold"},
            {targets: 6, width: '20%', className:"text-left font-weight-bold"},
            {targets: 7, width: '2%', className:"text-center font-weight-bold"},
        ],
        ajax: {
            url: 'api/v3/ticket/datatable',
            beforeSend: function(){
                $(".loadingoverlay").addClass("d-none");
            },
            type: 'POST',
            headers: {"Authorization": "Bearer " + api_token},
            data: function(d){
                d.searchTicket = $("#searchTicket").val();
                d.branch = $("#branchFilter").val();
                d.department = $("#departmentFilter").val();
                d.category = $("#categoryFilter").val();
                d.subject = $("#subjectFilter").val();
                d.level = $("#levelFilter").val();
                d.dateFrom = $("#datefromFilter").val();
                d.dateTo = $("#datetoFilter").val();
                d.status = $("#statusFilter").val();
            },
            error: function(xhr, error, thrown){
                errorDataTable("Ticket List");
            }
        }
    });

    $("#searchTicketBtn").click((e) => {
        ticketListTable.draw();
    });

    $("#searchTicket").keyup((e) => {
        ticketListTable.draw();
    });

    $("#branchFilter,#departmentFilter,#categoryFilter,#subjectFilter,#levelFilter,#datefromFilter,#datetoFilter,#statusFilter").change((e) => {
        e.preventDefault();
        ticketListTable.draw();
    });

    $("#clearFilter").click((e) => {
        $("#searchTicket").val("");
        $("#branchFilter,#departmentFilter,#categoryFilter,#subjectFilter,#levelFilter,#datefromFilter,#datetoFilter,#statusFilter").val("").trigger("change");
        ticketListTable.draw();
    });

    ticketListTable.on('click', '.viewTicket', (e) => {
        e.preventDefault();
        let ticketId = $(e.currentTarget).parent().data("ticketid");
        let getTicket = ajaxPostRequest(api_token, `api/v3/ticket/get/${ticketId}`);
        getTicket.done((res, textStatus, xhr) => {
            if(xhr.status == 200){  
                res.forEach(data => {
                    $(".content").load($(e.currentTarget).attr("href"), ( res, status, xhr) => {
                        if(status == "success"){
                            viewTicketTab(data);
                        }else{
                            notifToast("Admin Page", "PAGE NOT FOUND","error");
                        }
                    });
                });
            }else{
                notifToast("Ticket List", res,"warning");
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

                case "Ticket List":
                    ticketListTab();
                break;
            }
        }else{
            notifToast("Admin Page", "PAGE NOT FOUND","error");
        }
    });
});