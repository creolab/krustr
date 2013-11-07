@extends('krustr::_layout.default')

@section('body_class')login @stop

@section('main')
	<div id="login" class="login">
		<h1><em>{{ Config::get('krustr::app_name') }}</em></h1>
		<h2>{{ Config::get('krustr::app_slogan') }}</h2>

		{{ Form::open(array('route' => 'backend.login.post')) }}

			<div class="form-group">
				<label for="email" class="control-label">Email</label>
				<div>
					<input type="text" name="email" value="" placeholder="Your email address..." class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label for="password" class="control-label">Password</label>
				<div>
					<input type="password" name="password" value="" placeholder="Your password..." class="form-control">
				</div>
			</div>

			<div class="form-group form-actions">
				<div>
					<button type="submit" class="btn btn-black btn-login">Sign in</button>
				</div>
			</div>

		{{ Form::close() }}
	</div>
@stop
