@extends('layouts.app')

@section('content')
    <div class="container-fluid login-container"  >
        <div class="container-sub"  >
            <div class="row" >
                <div class="col-md-6 login-left-content" style="" >
                    <div class="row">
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-10" >

                            <div class="height-5"> </div>

                            <h3>
                                {!! trans('paragraph.ads')[0]['title'] !!}
                            </h3>
                            <p>
                                {!! trans('paragraph.ads')[0]['message'] !!}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 login-right-content" >


                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-10" >

                                <div class="height-5"> </div>

                                <div>
                                    <h4> Login </h4>
                                </div>

                                <div class="height-2"> </div>

                                <div>
                                    <div class="form-group login-email-container" >
                                        <label>Email</label>

                                        <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your email" name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group login-password-container"  >
                                        <label>Password</label>

                                        <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"  id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter your password" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group row login-remember-me">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                            <label class="form-check-label" for="remember">
                                                Remember Me
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="form-control btn btn-outline-primary">
                                            Login
                                        </button>
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
