const ajaxPostRequest = (token, url, data = {}) => {
    return $.ajax({
        type:"POST",
        headers: {"Authorization": "Bearer " + token},
        url:url,
        data: data
    });
}

const ajaxPostFile = (token, url, data = {}) => {
    return $.ajax({
        type:"POST",
        headers: {"Authorization": "Bearer " + token},
        url:url,
        data: data,
        processData: false,
        contentType: false
    });
}

const fetchAPI = (token, url, data = {}) => {
    return fetch(url, {
        method: 'POST',
        headers: {
            "Authorization": "Bearer " + token,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    });
}

const select2GenerateData = (data,elementId,elementFont = "") => {
    let select2Data = [];
    if(data.length != 0){
        data.forEach(element => {
            select2Data.push({
                id: element.Id,
                text: element.Name
            });
        });

        $(elementId).select2({
            theme: 'bootstrap4',
            data:select2Data
        });
        
        $(elementId).next().find(".select2-search__field").attr("name","search-"+elementId.replace("#","")).attr("id","search-"+elementId.replace("#",""));

        if(elementFont != ""){
            $(elementFont).css("font-weight","500");
            $(elementFont).css("color","#000000");
        }
    }
    
}

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

const viewTicketTab = (data) => {
    let category = data.category;
    let subject = data.subject;
    let reporter = data.reporter;
    let level = data.priorityLevel;
    let assignee = data.assignee;
    let levelColor = "";
    let statusColor = "";
    let api_token = localStorage.getItem("api_token");

    $(".ticketCategoryLabel").text(category.name +" - "+ subject.name);
    $(".tabTitle").text("VIEW TICKET: " + data.ticketNoLabel);
    $("#backBtn").html("<i class='fas fa-arrow-left'></i> Return to " + $(".tabLink.active").find("p").text().toLowerCase());

    if(assignee != null){
        let assigneeProfile = assignee.profile == null ? defaultProfile : assignee.profile;
        let assigneeName = assignee.prefix +" "+ assignee.firstname +" "+ assignee.lastname;

        $(".ticketAssignee").html("<img class='user-image img-circle elevation-1 m-auto navProfile' alt='user' title='"+assignee.department.name+" - "+assigneeName+"' src='"+assigneeProfile+"'/> "+assigneeName+"");
    }else{
        $(".ticketAssignee").addClass("text-muted").text("Unassigned");
    }

    let reporterProfile = reporter.profile == null ? defaultProfile : reporter.profile;
    let reporterName = reporter.prefix +" "+ reporter.firstname +" "+ reporter.lastname;

    $(".ticketReporter").html("<img class='user-image img-circle elevation-1 m-auto navProfile' alt='user' title='"+reporter.department.name+" - "+reporterName+"' src='"+reporterProfile+"'/> "+reporterName+"");

    $(".ticketBranch").text(reporter.branch.name);
    $(".ticketDepartment").text(reporter.department.name);

    switch(level.value){
        case 1:
            levelColor = "#1e7e34";
        break;

        case 2:
            levelColor = "#117a8b";
        break;

        case 3:
            levelColor = "#d39e00";
        break;

        case 4:
            levelColor = "#bd2130";
        break;
    }

    $(".ticketLevel").html("<i class='fas fa-bars' style='color:"+levelColor+";'></i> <b>"+level.label+"</b>");
    switch(data.status.value){
        case 1:
            statusColor = "bg-secondary";
        break;

        case 2:
            statusColor = "bg-info";
        break;

        case 4:
            statusColor = "bg-black";
        break;

        default:
            statusColor = "bg-primary";
        break;
    }

    $(".ticketStatus").addClass(statusColor).text(data.status.label);
    $(".ticketDateCreated").text(data.date);
    $(".ticketCategorySubject").text(category.name +" - "+ subject.name);
    let attachmentCtr = 0;

    data.attach.forEach((image) => {
        if(image != null){
            attachmentCtr++;
            let imageElement = $("<div class='col-lg-2 col-md-3 col-sm-12 p-1'><div class='img-fluid elevation-2 carouselImage'><img class='carouselSetImage' alt='attachment image'  width='100' height='100' src='"+image+"'/></div></div>");

            let attachmentGallery = $("<div data-toggle='lightbox' data-gallery='hidden-images' data-remote='"+image+"'></div>");
    
            imageElement.find("img").click((e) => {
                e.preventDefault();
                $(attachmentGallery).ekkoLightbox();
            });
    
            $(".attachmentContainer").append(imageElement).append(attachmentGallery);
        }
    });

    $(".attachLabel").text("Attachments ("+attachmentCtr+")");

    if(data.description != "" && data.description != null){
        $(".ticketDescription").html(data.description);
    }
    const generateComment = () => {
        let ticketComment = ajaxPostRequest(api_token, "api/v3/ticket/comment/"+data.id);
        $(".commentContainer").empty();
        ticketComment.done((res, textStatus, xhr) => {
            if(xhr.status == 200 && res.length != 0){
                $(".ticketCommentLabel").text("Comments ("+res.length+")");
                res.forEach( commentData => {
                    let userComment = commentData.user;
                    let profile = userComment.profile != null ? userComment.profile : defaultProfile;
                    let userName = userComment.prefix +" "+ userComment.firstname +" "+ userComment.lastname;
                    let comment = $("<div class='col-12'><p class='mb-0 font-weight-bold ticketUserComment'></p><p class='mt-1 p-2 border border-gray rounded ticketComment'></p></div>");
                    comment.find(".ticketUserComment").html("<img class='user-image img-circle elevation-1 m-auto navProfile' alt='user' src='"+profile+"'/> "+userName+" <small class='p-1 bg-light rounded'></small>");
                    comment.find(".ticketComment").text(commentData.comment);
                    comment.find("small").text(commentData.date);
                    $(".commentContainer").append(comment);
                });
            }
        });
    }

    generateComment();

    $("#ticketCommentForm").submit((e) => {
        e.preventDefault();
        let formData = $(e.currentTarget).serializeArray();
        formData.push({
            name: "ticketId",
            value: data.id
        });
        let writeComment = ajaxPostRequest(api_token, "api/v3/comment/create",formData);
        writeComment.done((res, textStatus, xhr) => {
            if(xhr.status == 200){
                generateComment();
                $("#commentInput").val("");
                notifToast("Write Comment", res,"success");
            }else{
                notifToast("Write Comment", res,"error");
            }
        });
    });

    $("#backBtn").click((e) => {
        e.preventDefault();
        $(".tabLink.active").trigger("click");
    });
}

const deleteTicket = (data) => {
    return Swal.fire({
        icon: "question",
        title: "Delete Ticket",
        text: "Are you sure you want to delete " + data.ticketNoLabel + " ticket?",
        confirmButtonText: 'Delete',
        showCancelButton: true,
        willOpen: (e) => {
            $(".swal2-actions").addClass("w-100").css("justify-content","flex-end");
        }
    }).then((result) => {
        if(result.isConfirmed){
            let api_token = localStorage.getItem("api_token");
            let deletePost = ajaxPostRequest(api_token, "api/v3/ticket/delete", {id: data.id});
            return deletePost.done((res, textStatus, xhr) => {
                if(xhr.status == 200){
                    notifToast("Ticket", res,"success");
                }else{
                    notifToast("Ticket", res,"error");
                }
            });
        }
    });
}

const generateTicketComponent = (filter = {}) => {
    let api_token = localStorage.getItem("api_token");
    let getTicket = ajaxPostRequest(api_token, "api/v3/ticket/get/0", filter);
    $(".todoContainer,.inprogressContainer,.doneContainer").empty();
    getTicket.done((res, textStatus, xhr) => {
        if(xhr.status == 200){
            res.forEach(data => {
                let ticket = $(".ticketContainer").clone();
                let category = data.category;
                let subject = data.subject;
                let reporter = data.reporter;
                let level = data.priorityLevel;
                let assignee = data.assignee;
                let levelColor = "";
        
                ticket.removeClass("d-none ticketContainer");
                ticket.find(".ticketNoLabel").text(data.ticketNoLabel);
                ticket.find(".ticketCategorySubject").text(category.name +" - "+ subject.name);
                ticket.find(".ticketReporter").text(reporter.prefix +" "+ reporter.firstname +" "+ reporter.lastname);
                ticket.find(".ticketBranchDepartment").text(reporter.branch.name +" - "+ reporter.department.name);
        
                switch(level.value){
                    case 1:
                        levelColor = "#1e7e34";
                        ticket.addClass("callout-success");
                    break;
        
                    case 2:
                        levelColor = "#117a8b";
                        ticket.addClass("callout-info");
                    break;
        
                    case 3:
                        levelColor = "#d39e00";
                        ticket.addClass("callout-warning");
                    break;
        
                    case 4:
                        levelColor = "#bd2130";
                        ticket.addClass("callout-danger");
                    break;
                }
                
                ticket.find(".ticketLevel").html("<i class='fas fa-bars' style='color:"+levelColor+";'></i> <b>"+level.label+"</b>");
                
                if(assignee != null){
                    let assigneeProfile = assignee.profile == null ? defaultProfile : assignee.profile;
                    let assigneeName = assignee.prefix +" "+ assignee.firstname +" "+ assignee.lastname;
        
                    ticket.find(".ticketAssignee").html("<img class='user-image img-circle elevation-1 m-auto navProfile' alt='user' title='"+assignee.department.name+" - "+assigneeName+"' src='"+assigneeProfile+"'/> "+assigneeName+"");
                    
                    ticket.find(".ticketAssignee").removeClass("d-none");
                }

                ticket.find(".viewTicket").click((e) => {
                    e.preventDefault();
                    $(".content").load($(e.currentTarget).attr("href"), ( res, status, xhr) => {
                        if(status == "success"){
                            viewTicketTab(data);
                        }else{
                            notifToast("Admin Page", "PAGE NOT FOUND","error");
                        }
                    });
                });

                ticket.find(".editTicket").click((e) => {
                    e.preventDefault();
                    $(".content").load($(e.currentTarget).attr("href"), ( res, status, xhr) => {
                        if(status == "success"){
                            newticketTab(data);
                        }else{
                            notifToast("Admin Page", "PAGE NOT FOUND","error");
                        }
                    });
                });

                ticket.find(".deleteTicket").click((e) => {
                    e.preventDefault();
                    let ticketDeleted = deleteTicket(data);
                    ticketDeleted.then((result) => {
                        let newfilter = {
                            branch: $("#branchFilter").val(),
                            department: $("#departmentFilter").val(),
                            category: $("#categoryFilter").val(),
                            subject: $("#subjectFilter").val(),
                            level: $("#levelFilter").val(),
                            datefrom: $("#datefromFilter").val(),
                            dateto: $("#datetoFilter").val(),
                        };

                        if(result == "Ticket Successfully Deleted."){
                            generateTicketComponent(newfilter);
                        }
                    });
                });

                switch(data.status.value){
                    case 1:
                        $(".todoContainer").append(ticket);
                    break;
        
                    case 2:
                        $(".inprogressContainer").append(ticket);
                    break;
        
                    case 3:
                        $(".doneContainer").append(ticket);
                    break;
                }
            });
        }else{
            notifToast("Ticket Board Tab", res,"warning");
        }
    });
}

$(document).ready((e) => {
    const mobileMediaQuery = window.matchMedia("(max-width: 576px)");

    function handleMobileMediaChange(e) {
        if (e.matches) {
            $("#navSearchTicketForm").addClass("hide-element");
        }else{
            $("#navSearchTicketForm").removeClass("hide-element");
        }
    }
    mobileMediaQuery.addListener(handleMobileMediaChange);
    handleMobileMediaChange(mobileMediaQuery);

    let sidebar = localStorage.getItem("sidebar");
    if(sidebar == "not-show"){
        $(".sidebar-logo").removeClass('d-flex justify-content-center align-items-center m-3').addClass('brand-link');
        $(".sidebar-logo-title").removeClass('d-none');
        $("body").addClass("sidebar-collapse");
    }
    else{
        $(".sidebar-logo").addClass('d-flex justify-content-center align-items-center m-3').removeClass('brand-link');
        $(".sidebar-logo-title").addClass('d-none');
        $("body").removeClass("sidebar-collapse"); 
    }
});

$("#logout").click((e) => {
    e.preventDefault();
    $.ajax({
        type:"POST",
        url:"postlogout",
        success: (res) => {
            localStorage.clear();
            location.reload();
        }
    });
});