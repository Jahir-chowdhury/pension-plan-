@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <center><h2 style="">Guardian Group Pension Plan</h2></center>
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card overflow-hidden">
                            <div class="row g-0">
                                <div class="col-lg-6">
                                    <div class="p-lg-5 p-4">

                                        <div>
                                            <h5>Welcome</h5>
                                            <p class="text-muted">Login to continue...</p>
                                        </div>
                                    
                                        <div class="mt-4 pt-3">
                                            <form method="POST" action="{{ route('login') }}">
                                                @csrf
                                                <div class="mb-3">
                                                    <label for="username" class="fw-semibold">{{ __('Email Address') }}</label>
                                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 mb-4">
                                                    <label for="userpassword" class="fw-semibold">{{ __('Password') }}</label>
                                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="row align-items-center">
                                                    <div class="col-6">
                                                        <div class="form-check">    
                                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="remember-check">{{ __('Remember Me') }}</label>
                                                        </div>
                                                    </div>  
                                                    <div class="col-6">
                                                        <div class="text-end">
                                                            <button class="btn btn-primary w-md waves-effect waves-light" type="submit"> {{ __('Login') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                        
                                                <div class="mt-4">
                                                    @if (Route::has('password.request'))
                                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                                        {{ __('Forgot Your Password?') }}
                                                    </a>
                                                @endif
                                                </div>
                                            </form>
                                        </div>
                    
                                    </div>
                                </div>

                                <div class="col-lg-6 bg-dark">
                                    <div class="p-lg-5 p-4 bg-auth h-100 d-none d-lg-block">
                                        <div class=" bg-dark">
                                            <span class="logo-sm">
                                                <img src="{{ asset('backend') }}/images/login.png" alt="logo-sm" style="max-width:100%;height:auto;">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <!-- end card -->
                        <div class="mt-5 text-center">
                            <p>© <script>document.write(new Date().getFullYear())</script> <b>Guardian Life Insurance.</b></p>
                        </div>
                    </div>
                    <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end account page -->
    </div>
</div>
@endsection
