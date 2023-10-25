<div class="container-fluid">
    <div class="card card-primary card-outline elevation-2 p-3">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="branchFilter">Branch</label>
                    <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Branch" id="branchFilter" name="branchFilter" style="width: 100%;">  
                    </select>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="departmentFilter">Department</label>
                    <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Department" id="departmentFilter" name="departmentFilter" style="width: 100%;">  
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="categoryFilter">Concern Category</label>
                    <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Category" id="categoryFilter" name="categoryFilter" style="width: 100%;">  
                    </select>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="subjectFilter">Subject</label>
                    <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Subject" id="subjectFilter" name="subjectFilter" disabled style="width: 100%;">  
                    </select>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="datefromFilter">Date From</label>
                    <input class="form-control" type="date" id="datefromFilter" name="datefromFilter" />  
                </div>
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="datetoFilter">Date To</label>
                    <input class="form-control" type="date" id="datetoFilter" name="datetoFilter" /> 
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12">
                <button class="btn btn-secondary font-weight-bold btn-lg mr-2" id="clearFilter"><i class="fas fa-filter"></i> Clear Filter</button>
                <button class="btn btn-primary font-weight-bold btn-lg" id="newTicketBtn" data-url="{{route("admin.newticket")}}"><i class="fas fa-plus"></i> New Ticket</button>
            </div>
        </div>
    </div>

    <div class="card-deck mb-5">
        <div class="card card-secondary elevation-2 bg-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bolder">To Do</h3>
            </div>
            <div class="card-body p-1 mt-2 mb-2">
            </div>
        </div>

        <div class="card card-info elevation-2 bg-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bolder">In Progress</h3>
            </div>
            <div class="card-body p-1 mt-2 mb-2">
            </div>
        </div>

        <div class="card card-primary elevation-2 bg-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bolder">Done</h3>
            </div>
            <div class="card-body p-1 mt-2 mb-2">
            </div>
        </div>
    </div>
</div>