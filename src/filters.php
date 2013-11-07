<?php

Route::filter('krustr.backend.auth', function()
{
	if (Auth::guest()) return \Krustr\Helpers\Redirect::adminRoute('login');
});

Route::filter('krustr.guest', function()
{
	if (Auth::check()) return \Krustr\Helpers\Redirect::to('/');
});
