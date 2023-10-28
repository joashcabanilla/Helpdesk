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
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="category">Concern Category</label>
                        <select class="form-control select2bs4" data-placeholder="Select Category" id="category" name="category" style="width: 100%;">
                            <option value=""></option>
                        </select>
                    </div>
                </div>
    
                <div class="col-lg-6 col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select class="form-control select2bs4" data-placeholder="Select Subject" id="subject" name="subject" disabled style="width: 100%;"> 
                            <option value=""></option>
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
        </form>
    </div>
</div>