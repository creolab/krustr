<?php

// Check if user is logged in and has access to admin section (min "editor" level)
Route::filter('krustr.backend.auth', function()
{
	if     (Vault::guest())           return \Krustr\Helpers\Redirect::adminRoute('login');
	elseif ( ! Vault::role('editor')) return Response::make(View::make('krustr::errors.forbidden'), 403);
});

// Check if user is already logged in
Route::filter('krustr.guest', function()
{
	if (Vault::check()) return \Krustr\Helpers\Redirect::to('/');
});

// Check if user is an admin
Route::filter('krustr.backend.acl.admin', function()
{
	if ( ! Vault::role('admin')) return Response::make(View::make('krustr::errors.forbidden'), 403);
});

// Check if user is an editor
Route::filter('krustr.backend.acl.editor', function()
{
	if ( ! Vault::role('editor')) return Response::make(View::make('krustr::errors.forbidden'), 403);
});

// Check if user is a super admin
Route::filter('krustr.backend.acl.super', function()
{
	if ( ! Vault::role('super')) return Response::make(View::make('krustr::errors.forbidden'), 403);
});
