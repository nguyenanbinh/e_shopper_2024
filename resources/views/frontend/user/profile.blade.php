@extends('frontend.layouts.app')
@section('content')
<div class="blog-post-area">
    <h2 class="title text-center">Update profile</h2>
    <div id="form" class="signup-form">
        <!--profile-form-->
        <form action="{{ route('profile') }}" method="POSt" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <input type="text" name="name" value="{{ $user->name }}" placeholder="name" class="@error('name') is-invalid @enderror" />

                @error('name')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="email" name="email" value="{{ $user->email }}" placeholder="email" class="@error('email') is-invalid @enderror" />

                @error('email')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="password"
                    class="@error('password') is-invalid @enderror" />

                @error('password')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <input type="text" name="address" value="{{ $user->address }}" placeholder="address"
                    class="@error('address') is-invalid @enderror" />

                @error('address')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <select name="country_id" class="form-control form-control-line">
                    @if(isset($countries) && $countries->count())
                    @foreach ($countries as $country)
                    <option value="{{ $country->id }}" @if($user->country_id == $country->id)
                        selected
                        @endif
                        >{{ $country->name }}
                    </option>
                    @endforeach
                    @else
                    <option>No data</option>
                    @endif
                </select>
            </div>
            <div class="form-group">
                <input type="text" name="phone" value="{{ $user->phone }}" placeholder="phone" class="@error('phone') is-invalid @enderror" />

                @error('phone')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label for="">Avatar preview</label>
                <img src="{{ $user->avatar_src }}" alt="" width="100" height="100">
            </div>
            <div class="form-group">
                <input type="file" name="avatar" placeholder="Avatar" class="@error('avatar') is-invalid @enderror" />

                @error('avatar')
                <span class="invalid-feedback">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <button type="submit" class="btn btn-default">Update</button>
        </form>
    </div>
</div>
<!--/profile-form-->
@endsection
