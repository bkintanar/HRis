@extends('master.adm-login-master')

@section('content')
	<div class="middle-box text-center loginscreen animated fadeInDown">
		<div>
			<div>

				<div class="logo-wrapper">
					<img src="/img/hris-logo-desaturated.png">
				</div>

			</div>
			<h3>{{ trans('app.register_to_hris') }}</h3>

			@if($errors->any())
				<div class="alert alert-danger">
					{{ $errors->first() }}<br>
				</div>
			@endif

			<form class="m-t" role="form" action="/auth/register" method="post" onSubmit="return check(this)">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">

				<div class="form-group">
					<input type="text" class="form-control" placeholder="First Name" name="first_name" required="">
				</div>
				<div class="form-group">
					<input type="text" class="form-control" placeholder="Last Name" name="last_name" required="">
				</div>
				<div class="form-group">
					<input type="email" class="form-control" placeholder="Email" name="email" required="">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="{{ trans('app.password') }}"
						   name="password" required="">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="{{ trans('app.password_confirmation') }}"
						   name="password_confirmation" required="">
				</div>
				<button type="submit" onclick="submit();" class="btn btn-primary block full-width m-b">Register</button>

				{{--<a href="#"><small>{{ trans('app.forgot_password?') }}</small></a>--}}
				<p class="text-muted text-center">
					<small>{{ trans('app.already_have_an_account?') }}</small>
				</p>
				<a class="btn btn-sm btn-white btn-block" href="/auth/login">{{ trans('app.login') }}</a>
			</form>
			<p class="m-t">
				<small>{{ trans('app.company_name') }} &copy; 2014</small>
			</p>
		</div>
	</div>
@stop
