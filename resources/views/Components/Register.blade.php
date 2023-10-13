@extends('Layouts.Guest')
@section('content')
<div class="register-box">
    <div class="card card-outline card-success">
      <div class="card-header text-center">
        <img src="{{asset('image/logo.png')}}" alt="logo" width="80" height="80"/>
        <img src="{{asset('image/mis.png')}}" alt="logo" width="80" height="80"/>
        <h4 class="mt-2"><b>{{ config('app.name', 'Laravel') }}</b></h4>
      </div>
      <div class="card-body">
        <h5><b>Sign up now</b></h5>
  
        <form id="registerForm" method="POST">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" id="email" autocomplete="true" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            <div class="invalid-feedback font-weight-bold error-email">
                error email
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="username" id="username" autocomplete="false" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
            <div class="invalid-feedback font-weight-bold error-username">
                error username
            </div>
          </div>

          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password" autocomplete="false" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div class="invalid-feedback font-weight-bold error-password">
                error password
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Confirm Password" id="password_confirmation" name="password_confirmation" autocomplete="false" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
            <div class="invalid-feedback font-weight-bold error-confirmpass">
                error confirm password
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
              <div class="icheck-success">
                <input type="checkbox" id="agreeTerms" name="terms" required>
                <label for="agreeTerms">
                 I agree to the <a href="" id="terms">terms</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-lg-4 col-md-4 col-sm-12">
              <button type="submit" class="btn btn-success btn-block font-weight-bold">Sign Up</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="social-auth-links text-center mt-2 mb-3">
          <a href="" id="googleAuth" class="btn btn-block btn-success font-weight-bold">
            <i class="fab fa-google-plus mr-2"></i> Sign up with Google
          </a>
        </div>

        <p class="mt-3 mb-0 font-weight-bold">Already have an account? <a href="{{route('landing.login')}}" class="text-center">Sign In</a></p>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
</div>
<!-- Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold" id="termsModalLabel">Terms and Condition</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span class="modal-closeIcon" aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        {!!$terms!!}
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success font-weight-bold" data-dismiss="modal">Accept</button>
      </div>
    </div>
  </div>
</div>
@endsection