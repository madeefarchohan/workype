@extends('layouts.app')

@section('content')

    <form action="{{ route('login') }}" class="log login-form" method="post" style="display:block !important;">
        @csrf
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>Please enter all required fields. </span>
        </div>

        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>Please enter all required fields. </span>
        </div>
        {{session()->get('status')}}
        @if (session('warning'))
            <div class="alert alert-warning">
                {{ session('warning') }}
            </div>
        @endif
        @if($errors->has('email') || $errors->has('password') || $errors->has('invalid_crediential'))
            <div class="alert alert-danger display-hide clearfix" style="display: block;">
                <button class="close" data-close="alert"></button>
            @include('flash::message')
            <!--                            @foreach ($errors->all() as $error)
                <span>{{ $error }}<br/></span>
                            @endforeach-->

                    @if($errors->has('invalid_crediential'))
                        {{$errors->first('invalid_crediential')}}
                    @endif
                    @if($errors->has('password'))
                        {{$errors->first('password')}}
                    @endif
                    @if($errors->has('email'))
                        {{$errors->first('email')}}
                    @endif

            </div>
        @endif

        <div class="row">
            <div class="col-xs-6">
                <input class="form-control form-control-solid placeholder-no-fix form-group" type="email" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}" required/>
            </div>
            <div class="col-xs-6">
                <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="password" required/>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-4">
                <div class="rem-password">
                    <label class="rememberme mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }} /> Remember me
                        <span></span>
                    </label>
                </div>
            </div>
            <div class="col-sm-8 text-right">
                <div class="forgot-password">
                    <a href="{{url('password/reset')}}"  >Forgot Password?</a>
                </div>
                <button class="btn green log-form" type="submit" name="btn_login">Sign In</button>
            </div>
        </div>
    </form>
@endsection
