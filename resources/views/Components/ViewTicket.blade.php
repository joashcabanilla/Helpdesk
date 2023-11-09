<div class="container-fluid">
    <div class="card card-primary bg-light card-outline elevation-2 p-3 col-12">
        <div class="row">
            <div class="col-12 mb-2">
                <a class="btn btn-primary btn-sm font-weight-bold float-right" id="backBtn"></a>
            </div>

            <div class="col-12">
                <div class="card-deck row">
                    <div class="col-lg-8 col-md-8 col-sm-12 card">
                        <div class="card-header p-2">
                            <h3 class="card-title font-weight-bolder">Ticket Details</h3>
                        </div>
                        <div class="card-body p-1 mt-2 mb-2 ticketDetailContainer">
                            <div class="row mt-2">
                                <div class="col-12">
                                    <p class="text-uppercase font-weight-bold bg-light p-1 ticketCategorySubject"></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <p class="font-weight-bold mt-1 mb-0 attachLabel">Attachments (0)</p>
                                </div>
                            </div>
                            <div class="row attachmentContainer mt-1"></div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <p class="font-weight-bold mt-1 mb-0">Description</p>
                                </div>
                                <div class="col-12 ticketDescription"></div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-12">
                                    <p class="font-weight-bold mt-1 mb-1 ticketCommentLabel">Comments (0)</p>
                                </div>
                            </div>

                            <div class="row commentContainer"></div>

                            <div class="row">
                                <div class="col-12">
                                    <form class="form-horizontal" id="ticketCommentForm">
                                        <div class="input-group mb-0">
                                          <textarea class="form-control" placeholder="Write a comment..." name="commentInput" id="commentInput" required></textarea>
                                          <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary w-100"><i class="fas fa-paper-plane"></i></button>
                                          </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            
                    <div class="col-lg-4 col-md-4 col-sm-12 card">
                        <div class="card-header p-2">
                            <h3 class="card-title font-weight-bolder">Reporter/Assignee Details</h3>
                        </div>
                        <div class="card-body p-1 mt-2 mb-2 ticketDetailContainer">
                            <div class="row mt-2">
                                <div class="col-6">
                                    <p class="font-weight-bold">Assignee</p>
                                </div>
                                <div class="col-6">
                                    <p class="ticketAssignee"></p>
                                </div>
                                <div class="col-6">
                                    <p class="font-weight-bold">Reporter</p>
                                </div>
                                <div class="col-6">
                                    <p class="ticketReporter"></p>
                                </div>
                                <div class="col-6">
                                    <p class="font-weight-bold">Branch</p>
                                </div>
                                <div class="col-6">
                                    <p class="ticketBranch"></p>
                                </div>
                                <div class="col-6">
                                    <p class="font-weight-bold">Department</p>
                                </div>
                                <div class="col-6">
                                    <p class="ticketDepartment"></p>
                                </div>
                                <div class="col-6">
                                    <p class="font-weight-bold">Priority Level</p>
                                </div>
                                <div class="col-6">
                                    <p class="ticketLevel"></p>
                                </div>
                                <div class="col-6">
                                    <p class="font-weight-bold">Status</p>
                                </div>
                                <div class="col-6">
                                    <p class="rounded text-center font-weight-bold p-1 ticketStatus">In Progress</p>
                                </div>
                                <div class="col-6">
                                    <p class="font-weight-bold">Date Created</p>
                                </div>
                                <div class="col-6">
                                    <p class="ticketDateCreated text-monospace">Date Created</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>