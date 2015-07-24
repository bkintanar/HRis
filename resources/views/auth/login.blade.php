@extends('master.adm-login-master')

@section('content')
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <div class="logo-wrapper">
                    <img src="/img/hris-logo.png">
                </div>

            </div>
            <h3>{{ trans('app.welcome_to_hris') }}</h3>

            @if (session('activation'))
                <div class="alert alert-success">
                    {{ session('activation') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}<br>
                </div>
            @endif

            <form class="m-t" role="form" action="/auth/login" method="post" onSubmit="return check(this)">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <div class="form-group">
                    <input type="email" class="form-control" placeholder="your-name@email.com" name="email" required="">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="{{ trans('app.password') }}" name="password" required="">
                </div>
                <button type="submit" onclick="submit();" class="btn btn-primary block full-width m-b">Login</button>

                <a href="#"><small>{{ trans('app.forgot_password?') }}</small></a>
                <p class="text-muted text-center"><small>{{ trans('app.do_you_have_an_account?') }}</small></p>
                <a class="btn btn-sm btn-white btn-block" href="/auth/register">{{ trans('app.create_an_account') }}</a>
            </form>
            <p class="m-t"> <small>b3 Studios &copy; 2014</small> </p>
        </div>
    </div>
@stop
