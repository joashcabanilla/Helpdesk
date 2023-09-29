@extends('Layouts.Guest')
@section('content')
<style>
.gradient-custom-2 {
    background: #002C56;

    background: -webkit-linear-gradient(to right, #002C56, #002C56, #002C56, #002C56);

    background: linear-gradient(to right, #002C56, #002C56, #002C56, #002C56);
}

@media (min-width: 768px) {
    .gradient-form {
        height: 100vh !important;
    }
}
@media (min-width: 769px) {
    .gradient-custom-2 {
        border-top-left-radius: .3rem;
        border-bottom-left-radius: .3rem;
    }
}
</style>

<section class="h-100 gradient-form" style="background-color: #eee;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-xl-10">
          <div class="card rounded-3 text-black">
            <div class="row g-0">
                <div class="col-lg-6 d-flex align-items-center justify-content-center p-3 gradient-custom-2">
                    <img src="{{asset('image/task.svg')}}" class="img-fluid" alt="task">
                </div>
              <div class="col-lg-6">
                <div class="card-body p-md-5 mx-md-4">
                  <div class="text-center">
                    <img src="{{asset('image/mis.png')}}" style="width: 100px;" alt="logo">
                    <h4 class="mt-4 mb-5 pb-1">{{config('app.name', 'Laravel')}}</h4>
                  </div>
  
                  <form>
                    <p class="fw-bold">Please login to your account</p>
  
                    <div class="form-outline mb-4">
                      <input type="email" id="form2Example11" class="form-control form-control-lg" />
                      <label class="form-label" for="form2Example11">Username</label>
                    </div>
  
                    <div class="form-outline mb-4">
                      <input type="password" id="form2Example22" class="form-control form-control-lg" />
                      <label class="form-label" for="form2Example22">Password</label>
                    </div>
  
                    <div class="text-center pt-1 mb-5 pb-1">
                      <button class="btn btn-primary btn-lg btn-block fa-lg gradient-custom-2 mb-3" type="button">Log
                        in</button>
                      <a class="text-muted" href="#!">Forgot password?</a>
                    </div>
  
                    <div class="text-center text-lg-start mt-4 pt-2">
                        <p class="small fw-bold mt-2 pt-1 mb-0">Don't have an account? <a href="#!"
                            class="link-danger">Register</a></p>
                      </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection