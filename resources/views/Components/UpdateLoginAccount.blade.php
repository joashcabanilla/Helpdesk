<!-- Modal -->
<div class="modal fade" id="updateLoginModal" tabindex="-1" role="dialog" aria-labelledby="updateLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title font-weight-bold" id="updateLoginModalLabel">Update Login Credentials</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span class="modal-closeIcon" aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="updateLoginForm" method="POST">
            <div class="modal-body">
              <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label for="updateEmail">Email</label>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control font-weight-bold" placeholder="Email" id="updateEmail" name="email" autocomplete="false" readonly>
                    </div>
                  </div>
                </div>
                
                <div class="col-12">
                  <div class="form-group">
                    <label for="updateUsername">Username</label>
                    <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="Username" id="updateUsername" name="username" autocomplete="false" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-user"></span>
                        </div>
                      </div>
                      <div class="invalid-feedback font-weight-bold error-updateUsername">
                        error username
                      </div>
                    </div>
                  </div>
                </div>
    
                <div class="col-12">
                  <div class="form-group">
                    <label for="updatePassword">Password</label>
                    <div class="input-group mb-3">
                      <input type="password" class="form-control" placeholder="Password" id="updatePassword" name="password" autocomplete="false" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                      <div class="invalid-feedback font-weight-bold error-updatePassword">
                        error password
                      </div>
                    </div>
                  </div>
                </div>
    
                <div class="col-12">
                  <div class="form-group mb-0">
                    <label for="updateConfirmPassword">Confirm Password</label>
                    <div class="input-group">
                      <input type="password" class="form-control" placeholder="Confirm Password" id="updateConfirmPassword" name="password_confirmation" autocomplete="false" required>
                      <div class="input-group-append">
                        <div class="input-group-text">
                          <span class="fas fa-lock"></span>
                        </div>
                      </div>
                      <div class="invalid-feedback font-weight-bold error-updateConfirmPassword">
                        error confirm password
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success font-weight-bold">Save</button>
              <a type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</a>
            </div>
        </form>
        
      </div>
    </div>
</div>