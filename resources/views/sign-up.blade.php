@section('header')
@include('header')
@show


<div class="login-content">
                <h3>Workype’s goal is to provide you and enterprise with the best business platform for new business opportunity and success.</h3>
 <form method="POST"  class="login-form register" action="{{ route('register') }}">
                        @csrf
                    <div class="alert alert-danger display-hide">
                        <button class="close" data-close="alert"></button>
                        <span>Please enter all required fields. </span>
                    </div>
                   
                    @if($errors->has('first_name') || $errors->has('last_name') || $errors->has('Password') || $errors->has('email') || $errors->has('agree'))
                        <div class="alert alert-danger display-hide clearfix" style="display: block;">
                            <button class="close" data-close="alert"></button>
                            @include('flash::message')
<!--                             @if($errors->has('email'))
                              {{$errors->first('email')}}
                            @endif
-->                         @if($errors->has('first_name'))
                                  {{$errors->first('first_name')}}<br>
                            @endif
                            @if($errors->has('last_name'))
                                  {{$errors->first('last_name')}}<br>
                            @endif
                            @if($errors->has('email'))
                                  {{$errors->first('email')}}<br>
                            @endif
                            @if($errors->has('Password'))
                            {{$errors->first('Password')}}<br>
                            @endif
                            @if($errors->has('agree'))
                                 {{$errors->first('agree')}}
                            @endif
<!--                            @foreach ($errors->all() as $error)
                                <span>{{ $error }}<br/></span>
                            @endforeach-->

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
                            <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('first_name') ? ' is-invalid' : '' }}" type="text" autocomplete="off" placeholder="First Name" name="first_name" value="{{ old('first_name') }}" required/>
                        </div>
                        <div class="col-xs-6">
                            <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" autocomplete="off" placeholder="Last Name" name="last_name"  value="{{ old('last_name') }}" required/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('email') ? ' is-invalid' : '' }}" type="text" autocomplete="off" placeholder="Email" name="email" value="{{ old('email') }}" required/>
                        </div>
                        <div class="col-xs-6">
                            <input class="form-control form-control-solid placeholder-no-fix form-group {{ $errors->has('password') ? ' is-invalid' : '' }}" type="password" autocomplete="off" placeholder="Password" name="Password" required/>
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
</div>

@section('footer')
@include('footer')
@show