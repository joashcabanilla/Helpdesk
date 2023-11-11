<div class="container-fluid">
    @include('Components.TicketBoardFilter')
    <div class="callout p-2 m-1 mb-2 d-none ticketContainer">
        <div class="row">
            <div class="col-12">
                <input type="hidden" name="ticketId" class="ticketId" />
                <p class="font-weight-bold float-left ticketNoLabel">ticket No Label</p>
                <div class="btn-group float-right">
                    <button type="button" class="btn btn-sm btn-light" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu dropdown-menu-right ticketMenuBtn">
                      <a class="dropdown-item viewTicket" href="{{route("admin.viewticket")}}"><i class="fas fa-eye"></i> View</a>
                      <a class="dropdown-item editTicket" href="{{route("admin.newticket")}}"><i class="fas fa-edit"></i> Edit</a>
                      <a class="dropdown-item deleteTicket" href=""><i class="fas fa-trash"></i> Delete</a>
                    </div>
                  </div>
            </div>
            <div class="col-12">
                <p class="text-uppercase font-weight-bold ticketCategorySubject">category - subject</p>
            </div>
            <div class="col-12 mt-2">
                <p class="ticketReporter">Reporter</p>
            </div>
            <div class="col-12">
                <p class="ticketBranchDepartment">Branch - Department</p>
            </div>
            <div class="col-12">
                <p class="ticketLevel">Priority Level</p>
            </div>
            <div class="col-12 mt-2">
                <p class="ticketAssignee d-none"></p>
            </div>
        </div>
    </div>

    <div class="card-deck mb-5">
        <div class="card card-secondary elevation-2 bg-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bolder">To Do</h3>
            </div>
            <div class="card-body p-2 mt-2 mb-2 todoContainer">
            </div>
        </div>

        <div class="card card-info elevation-2 bg-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bolder">In Progress</h3>
            </div>
            <div class="card-body p-1 mt-2 mb-2 inprogressContainer">
            </div>
        </div>

        <div class="card card-primary elevation-2 bg-light">
            <div class="card-header">
                <h3 class="card-title font-weight-bolder">Done</h3>
            </div>
            <div class="card-body p-1 mt-2 mb-2 doneContainer">
            </div>
        </div>
    </div>
</div>