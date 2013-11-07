<div class="auth-header">
	<div class="profile clearfix">
		<img src="{{ gravatar(Auth::user()->email, array('s' => 13)) }}" width="13" height="13" alt="{{ Auth::user()->first_name }}">
		<p>Hello, <a href="#">{{ Auth::user()->first_name }}</a></p>
	</div>
	<a href="{{ admin_route('logout') }}" class="logout">{{ admin_icn('lock') }} Logout</a>
</div>
