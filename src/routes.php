<?php

$backendPrefix = Config::get('krustr::backend_url');
$apiPrefix     = Config::get('krustr::api_url');
$controller    = 'Krustr\Controllers\\';
$api           = $controller.'Api\\';
$admin         = $controller.'Admin\\';
$channels      = App::make('krustr.channels');
$taxonomies    = App::make('krustr.taxonomies');

// ! Assets settings
if (Request::segment(1) == $backendPrefix)
{
	Config::set('assets::public_path', 'packages/creolab/krustr/assets');
	Config::set('assets::cache_path',  'packages/creolab/krustr/assets/cache');
}
else
{
	Config::set('assets::public_path', 'themes/'.Config::get('krustr::theme').'/assets');
	Config::set('assets::cache_path',  'themes/'.Config::get('krustr::theme').'/assets/cache');
}
app('assets')->configure();

// ! Auth routes
Route::get($backendPrefix.'/logout',  array('as' => $backendPrefix.'.logout',      'uses' => $admin.'AuthController@getLogout'));
Route::get($backendPrefix.'/login',   array('as' => $backendPrefix.'.login',       'uses' => $admin.'AuthController@getLogin'));
Route::post($backendPrefix.'/login',  array('as' => $backendPrefix.'.login.post',  'uses' => $admin.'AuthController@postLogin'));

// ! Backend routes
if (Request::segment(1) == $backendPrefix)
{
	Route::group(array('prefix' => $backendPrefix, 'before' => 'krustr.backend.auth'), function() use ($admin, $channels, $taxonomies, $backendPrefix)
	{
		Route::get('/', array('as' => $backendPrefix . '.dashboard', 'uses' => $admin.'DashboardController@index'));

		// ! ===> Redirect to 1st channel
		Route::get('content', array('as' => $backendPrefix . '.content', function() use ($channels, $backendPrefix) {
			return Redirect::to($backendPrefix . '/content/' . key($channels));
		}));

		// ! ===> Content channels
		foreach ($channels as $key => $channel)
		{
			Route::resource('content/'.$channel->name, $admin.'EntryController');
		}

		// ! ===> Redirect to 1st taxonomy
		Route::get('taxonomies', array('as' => $backendPrefix . '.taxonomy', function() use ($taxonomies, $backendPrefix) {
			return Redirect::to($backendPrefix . '/taxonomies/' . key($taxonomies));
		}));

		// ! ===> Taxonomies
		foreach ($taxonomies as $key => $taxonomy)
		{
			Route::resource('taxonomies/'.$taxonomy->name, $admin.'TermController');
		}

		// ! ===> System
		Route::resource('system/users', $admin.'UsersController');
		Route::get('system',            array('as' => $backendPrefix . '.system', 'uses' => $admin.'SystemController@getUsers'));

	});
}

// ! API routes
if (Request::segment(1) == $apiPrefix or Request::segment(1) == $backendPrefix)
{
	Route::group(array('prefix' => $apiPrefix, 'before' => 'krustr.backend.auth'), function() use ($apiPrefix, $api, $channels, $taxonomies)
	{
		Route::get('/', function() { return array('version' => '1.0.0'); });
		Route::resource('entries', $api.'EntryController');

		// ! ===> Content channels
		foreach ($channels as $key => $channel)
		{
			Route::resource('content/'.$key, $api.'EntryController');
		}

		// ! ===> Taxonomies and terms
		foreach ($taxonomies as $key => $taxonomy)
		{
			Route::get('taxonomy/'.$taxonomy->name_singular,          $api.'TaxonomyController@get');
			Route::get('taxonomy/'.$taxonomy->name_singular.'/terms', $api.'TermController@index');
		}

		// ! ===> Upload and media
		Route::any('upload',                            array('as' => $apiPrefix . '.upload',             'uses' => $api . 'UploadController@fire'));
		Route::delete('media/entry/{entry}/field/{id}', array('as' => $apiPrefix . '.media.field.delete', 'uses' => $api . 'MediaController@destroyField'));
		Route::delete('media/{id}',                     array('as' => $apiPrefix . '.media.delete',       'uses' => $api . 'MediaController@destroy'));
		Route::get('media/{id}',                        array('as' => $apiPrefix . '.media.delete.get',   'uses' => $api . 'MediaController@destroy'));
	});
}

// Theme routes
if (file_exists($routes = public_path() . '/themes/' . Config::get('krustr::theme') . '/routes.php'))
{
	include $routes;
}

// Feed routes
Route::get('feed.{type}', 'Krustr\Controllers\FeedController@feed');

// ! Public content routes
app('krustr.router')->init();
