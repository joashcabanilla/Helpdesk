@extends('Layouts.Guest')
@section('content')
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <img src="{{asset('image/logo.png')}}" alt="logo" width="80" height="80"/>
        <img src="{{asset('image/mis.png')}}" alt="logo" width="80" height="80"/>
        <h4 class="mt-2"><b>{{ config('app.name', 'Laravel') }}</b></h4>
      </div>
      <div class="card-body">
        <h5><b>Sign into your account</b></h5>
  
        <form id="loginForm" method="POST">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username / Email" id="username" name="username" autocomplete="false" required autofocus>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-1">
            <input type="password" class="form-control" placeholder="Password" id="password" name="password" autocomplete="false" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row mb-2">
            <div class="col-12">
              <div class="icheck-success">
                <input type="checkbox" id="showPassword" name="showpassword">
                <label for="showPassword">Show password</label>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-12">
                <p class="mb-1">
                    <a href="" class="font-weight-bold" id="forgotPassword">Forgot password?</a>
                </p>
            </div>
            <!-- /.col -->
            <div class="col-lg-4 col-md-4 col-sm-12">
              <button type="submit" class="btn btn-primary btn-block font-weight-bold">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>
  
        <div class="social-auth-links text-center mt-2 mb-3">
          <a href="" id="googleAuth" class="btn btn-block btn-primary font-weight-bold">
            <i class="fab fa-google-plus mr-2"></i> Sign in with Google
          </a>
        </div>
        <!-- /.social-auth-links -->
        <p class="mb-0 font-weight-bold">
            Don't have an account?<a href="{{route('landing.register')}}" id="registerLink" class="text-center"> Sign Up</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  @include('Components.UpdateLoginAccount')
@endsection