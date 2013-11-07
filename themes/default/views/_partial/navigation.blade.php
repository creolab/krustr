<nav class="navbar navbar-default" role="navigation">
	<!-- Brand and toggle get grouped for better mobile display -->
	<div class="navbar-header">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
	</div>

	<div class="collapse navbar-collapse navbar-ex1-collapse">
		<ul class="nav navbar-nav">
			<li class="active"><a href="{{ route('site.home') }}">Home</a></li>
			<li><a href="{{ url('pages/about-us') }}">About us</a></li>
			<li><a href="{{ url('blog') }}">Blog</a></li>
			<li><a href="{{ url('shop') }}">Shop</a></li>
			<li><a href="{{ url('contact') }}">Contact</a></li>
		</ul>
	</div>
</nav>
