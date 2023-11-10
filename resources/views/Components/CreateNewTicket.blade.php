<div class="container-fluid">
    <div class="card card-primary card-outline elevation-2 p-3 col-lg-8 col-md-10 col-sm-12">

        <div class="row">
            <div class="col-12">
                <a class="btn btn-primary btn-sm font-weight-bold float-right" id="backBtn"></a>
            </div>
        </div>

        <form id="newTicketform" method="POST" enctype="multipart/form-data">
            <div class="row attachmentInput d-none"></div>
            
            <div class="row mt-3">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="category">Concern Category</label>
                        <select class="form-control select2bs4" data-placeholder="Select Category" id="category" name="category" style="width: 100%;" required>
                            <option value=""></option>
                        </select>
                    </div>
                </div>
    
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select class="form-control select2bs4" data-placeholder="Select Subject" id="subject" name="subject" disabled style="width: 100%;" required> 
                            <option value=""></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="form-group">
                        <label for="priorityLevel">Priority Level</label>
                        <select class="form-control select2bs4" id="priorityLevel" name="level" style="width: 100%;" data-placeholder="Select Level" required>  
                            <option value=""></option>
                            <option value="1">Low</option>
                            <option value="2">Medium</option>
                            <option value="3">High</option>
                            <option value="4">Urgent</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <p class="font-weight-bold float-left mt-1 mb-0 mr-1 attachLabel">Attachments (0)</p>
                    <div class="float-right">
                        <a class="btn btn-sm btn-light font-weight-bold addDelete" id="attachDelete" title="delete all"><i class="fas fa-trash"></i></a>
                        <a class="btn btn-sm btn-light font-weight-bold addDelete" id="attachAdd"  title="add Image"><i class="fas fa-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="row attachmentContainer"></div>

            <div class="row mt-2">
                <div class="col-12">
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 text-center">
                    <button class="btn btn-lg btn-primary font-weight-bold" type="submit" id="createTicketBtn">Create Ticket</button>
                </div>
            </div>
        </form>
    </div>
</div>