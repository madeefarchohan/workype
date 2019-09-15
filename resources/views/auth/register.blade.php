@extends('layouts.app')

@section('content')
    <form method="POST"  class="login-form register" action="{{ route('register') }}">
        @csrf
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span>Please enter all required fields. </span>
        </div>

        @if($errors->has('first_name') || $errors->has('last_name') || $errors->has('username') || $errors->has('Password') || $errors->has('email') || $errors->has('agree'))
            <div class="alert alert-danger display-hide clearfix" style="display: block; max-height:95px; overflow-y: auto;">
                <button class="close" data-close="alert"></button>
                @include('flash::message')
                {{--{{dd($errors->all())}}--}}
                @if($errors->any())
                    <ul>
                @foreach ($errors->all() as $error)

                     <li>{{$error}}</li>

                @endforeach
                    </ul>
                    @endif

            </div>
        @endif


        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
    @endif

    <!--                    @if (session('warning'))
        <div class="alert alert-warning">
{{ session('warning') }}
                </div>
            @endif-->



            <div class="row">
                <div class="col-xs-6">
                    <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('first_name') ? ' is-invalid' : '' }}" type="text" autocomplete="off" placeholder="First Name" title="Characters only" pattern="^[A-Za-z\s]{1,191}$" name="first_name" value="{{ old('first_name') }}" required/>
                </div>
                <div class="col-xs-6">
                    <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" autocomplete="off" placeholder="Last Name" title="Characters only" pattern="^[A-Za-z\s]{1,191}$" name="last_name"  value="{{ old('last_name') }}" required/>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('username') ? ' is-invalid' : '' }}" type="text"    autocomplete="off" title="1-15 Characters, integers or underscore" placeholder="Username" name="username" value="{{ old('username') }}" required/>
                </div>

                <div class="col-xs-6">
                    <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" title="person@example.com" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}" required/>
                </div>

            </div>

            <div class="row">
                <div class="col-xs-12">

                    {{--<input id="password-field" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('password') ? ' is-invalid' : '' }}" pattern="^((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@#$%]).{6,})" type="password" autocomplete="off" title="Minimum 6 characters. Must Contain at least one Special Characters(@,$,!,&,*). Must have 1 uppercase Alphabet. Password should be combination of numbers,special characters and strings. " placeholder="Password" name="Password" required/>--}}
                    <input id="password-field" class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('password') ? ' is-invalid' : '' }}"  type="password" autocomplete="off"
                           title="Should have at least one uppercase letter,lower case letter,numeric value and, special character. Must be more than 6 characters long." placeholder="Password" name="Password" required/>


                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password pull-right" style="margin-top:-50px; cursor: pointer"></span>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label class="mt-checkbox mt-checkbox-outline">
                            <input type="checkbox" name="agree" {{ old('agree') ? 'checked' : '' }}> I agree to the
                            <a href="javascript:;">Terms of Service </a> &amp;
                            <a href="javascript:;">Privacy Policy </a>
                            <span></span>
                        </label>
                    </div>
                </div>
                <div class="col-sm-4 text-right">
                    <button class="btn green" type="submit" name="btn_register"> {{ __('Register') }}</button>

                </div>
            </div>
    </form>
@endsection