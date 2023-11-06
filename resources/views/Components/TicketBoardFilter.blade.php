<div class="card card-primary card-outline elevation-2 p-3">
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="branchFilter">Branch</label>
                <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Branch" id="branchFilter" name="branchFilter" style="width: 100%;">  
                </select>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="departmentFilter">Department</label>
                <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Department" id="departmentFilter" name="departmentFilter" style="width: 100%;">  
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="categoryFilter">Concern Category</label>
                <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Category" id="categoryFilter" name="categoryFilter" style="width: 100%;">  
                </select>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="subjectFilter">Subject</label>
                <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Subject" id="subjectFilter" name="subjectFilter" disabled style="width: 100%;">  
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="levelFilter">Priority Level</label>
                <select class="form-control select2bs4" multiple="multiple" data-placeholder="Select Level" id="levelFilter" name="levelFilter" style="width: 100%;">  
                    <option value="1">Low</option>
                    <option value="2">Medium</option>
                    <option value="3">High</option>
                    <option value="4">Urgent</option>
                </select>
            </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="datefromFilter">Date From</label>
                <input class="form-control" type="date" id="datefromFilter" name="datefromFilter" />  
            </div>
        </div>
        
        <div class="col-lg-3 col-md-4 col-sm-12">
            <div class="form-group">
                <label for="datetoFilter">Date To</label>
                <input class="form-control" type="date" id="datetoFilter" name="datetoFilter" /> 
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-12">
            <label for="datetoFilter"> &nbsp;</label>
            <div class="form-group">
                <button class="btn btn-secondary font-weight-bold mr-2" id="clearFilter"><i class="fas fa-filter"></i> Clear Filter</button>
                <button class="btn btn-primary font-weight-bold" id="newTicketBtn" data-url="{{route("admin.newticket")}}"><i class="fas fa-plus"></i> New Ticket</button>
            </div> 
        </div>
    </div>
</div>