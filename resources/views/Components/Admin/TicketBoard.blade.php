<div class="container-fluid">
    <div class="card card-primary card-outline elevation-2 p-3">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="boardFilter">Board</label>
                    <select class="form-control select2bs4 font-weight-bold" multiple="multiple" data-placeholder="Select Board" id="boardFilter" name="boardFilter">  
                    </select>
                </div>
            </div>

            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="branchFilter">Branch</label>
                    <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Branch" id="branchFilter" name="branchFilter">  
                    </select>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="departmentFilter">Department</label>
                    <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Department" id="departmentFilter" name="departmentFilter">  
                    </select>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="form-group">
                    <label for="subjectFilter">Subject</label>
                    <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Subject" id="subjectFilter" name="subjectFilter">  
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

            <div class="col-lg-4 col-md-4 col-sm-12">
                <button class="btn btn-primary font-weight-bold btn-lg"><i class="fas fa-plus"></i> New Ticket</button>
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