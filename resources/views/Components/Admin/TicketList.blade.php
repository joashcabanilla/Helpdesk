<div class="container-fluid">
    @include('Components.TicketBoardFilter',["ticketStatus" => true])
    <div class="card card-primary card-outline elevation-2 p-3">
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="form-group">
                    <div class="input-group input-group-lg">
                        <input type="search" class="form-control form-control-lg" id="searchTicket"  placeholder="Search Ticket">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-lg btn-default" id="searchTicketBtn">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="ticketListTable" class="table table-hover table-bordered dataTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ticket No</th>
                        <th>Branch</th>
                        <th>Department</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Reporter</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>