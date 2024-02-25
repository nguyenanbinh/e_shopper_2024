@extends('frontend.layouts.app')
@section('content')
<section id="form">
    <!--form-->
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-form">
                    <!--login form-->
                    <h2>Login to your account</h2>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email"
                                class="@error('email') is-invalid @enderror" />

                            @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password"
                                class="@error('password') is-invalid @enderror" />

                            @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <span>
                            <input type="checkbox" name="remember" class="checkbox">
                            Keep me signed in
                        </span>

                        <button type="submit" class="btn btn-default">Login</button>
                    </form>
                </div>
                <!--/login form-->
            </div>
        </div>
    </div>
</section>
<!--/form-->
@endsection
