@extends('frontend.layouts.app')
@section('content')
<section id="form"><!--form-->
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-form"><!--register form-->
                    <h2>Register your account</h2>
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="name" placeholder="Name"
                                class="@error('name') is-invalid @enderror" />

                            @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
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
                        <div class="form-group">
                            <input type="password" name="password_confirmation" placeholder="Password confirm"
                                class="@error('password_confirmation') is-invalid @enderror" />

                            @error('password_confirmation')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-default">Register</button>
                    </form>
                </div><!--/register form-->
            </div>
        </div>
    </div>
</section><!--/form-->
@endsection
