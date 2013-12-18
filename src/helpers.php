<?php

if ( ! function_exists('admin_assets'))
{
	/**
	 * Include an asset
	 *
	 * @param  string $path
	 * @return string
	 */
	function admin_assets($path = null)
	{
		return asset('/packages/creolab/krustr/assets/'.$path);
	}
}

if ( ! function_exists('theme_assets'))
{
	/**
	 * Include theme assets
	 *
	 * @param  string $path
	 * @return string
	 */
	function theme_assets($collection = 'theme.css', $assets = array(), $options = array())
	{
		// Set paths for theme
		$theme = app('config')->get('krustr::theme');
		app('config')->set('assets::public_dir', "themes/$theme/assets");
		app('config')->set('assets::cache_path', "themes/$theme/assets/cache");

		// Find collection config
		$configCollection = str_replace(".", "_", $collection);
		$config           = app('config')->get('theme::assets.'.$configCollection);

		if ($config and is_array($config))
		{
			$assets  = array_get($config, 'assets');
			$options = array_except($config, 'assets');

			if ( ! $name = array_get($options, 'name')) $options['name'] = $collection;
		}
		elseif (array_get($assets, 'assets'))
		{
			$assets          = array_get($assets, 'assets');
			$options         = array_except($assets, 'assets');
			$options['name'] = $collection;
		}

		return app('assets')->assets($collection, $assets, $options);
	}
}

if ( ! function_exists('theme_asset_tag'))
{
	/**
	 * Include a theme asset
	 *
	 * @param  string $path
	 * @return string
	 */
	function theme_asset_tag($path = null)
	{
		$path = theme_asset($path);
		$ext  = pathinfo($path, PATHINFO_EXTENSION);

		if     ($ext == 'js')  return '<script src="'.$path.'"></script>'.PHP_EOL;
		elseif ($ext == 'css') return '<link rel="stylesheet" href="'.$path.'">'.PHP_EOL;
		elseif ($ext == 'jpg') return '<img src="'.$path.'">'.PHP_EOL;
		else                   return $path.PHP_EOL;
	}
}

if ( ! function_exists('admin_route'))
{
	/**
	 * Generate route to admin resource
	 *
	 * @param  string $path
	 * @param  mixed  $id
	 * @return string
	 */
	function admin_route($path = null, $id = null)
	{
		if ($path) return route(Config::get('krustr::backend_url') . '.' . $path, $id);
		else       return route(Config::get('krustr::backend_url'));
	}
}

if ( ! function_exists('api_route'))
{
	/**
	 * Generate route to API resource
	 *
	 * @param  string $path
	 * @param  mixed  $id
	 * @return string
	 */
	function api_route($path = null, $id = null)
	{
		return route(Config::get('krustr::api_url') . '.' . $path, $id);
	}
}

if ( ! function_exists('admin_icn'))
{
	/**
	 * Generate icon tag
	 *
	 * @param  string $icon
	 * @return string
	 */
	function admin_icn($icon)
	{
		if ($icon)
		{
			$iconClass = 'icn icon icon-' . $icon;

			return '<i class="' . $iconClass . '"></i>';
		}
	}
}

if ( ! function_exists('admin_glicn'))
{
	/**
	 * Generate icon tag
	 *
	 * @param  string $icon
	 * @return string
	 */
	function admin_glicn($icon)
	{
		if ($icon)
		{
			$iconClass = 'icn glyphicon glyphicon-' . $icon;

			return '<i class="' . $iconClass . '"></i>';
		}
	}
}

if ( ! function_exists('template_class'))
{
	/**
	 * Generate class for current template
	 *
	 * @return string
	 */
	function template_class()
	{
		return app('krustr.theme')->templateClass();
	}
}

if ( ! function_exists('admin_title'))
{
	/**
	 * Generate meta title for backend pages
	 *
	 * @return string
	 */
	function admin_title()
	{
		$title = app('config')->get('krustr::app_name');

		// Current route
		$part = app('view')->shared('meta_title');
		if ($part) $title = $part . ' | ' . $title;

		return $title;
	}
}

if ( ! function_exists('gravatar'))
{
	/**
	 * Generate Gravatar URL
	 *
	 * @return string
	 */
	function gravatar($email, $options = array())
	{
		$url = 'http://www.gravatar.com/avatar/' . md5($email);

		// Params
		$params = array();
		if ($options)
		{
			foreach ($options as $key => $value)
			{
				$params[] = $key . '=' . $value;
			}
		}

		// Add params to URL
		if ($params)
		{
			$url .= '?' . implode("&", $params);
		}

		return $url;
	}
}

if ( ! function_exists('image'))
{
	/**
	 * Resize an image
	 * @param  string  $url
	 * @param  integer $width
	 * @param  integer $height
	 * @param  boolean $crop
	 * @return string
	 */
	function image($url, $width = 100, $height = null, $crop = false, $quality = null)
	{
		return Creolab\Image\ImageFacade::resize($url, $width, $height, $crop, $quality);
	}
}

if ( ! function_exists('thumb'))
{
	/**
	 * Helper for creating thumbs
	 * @param  string  $url
	 * @param  integer $width
	 * @param  integer $height
	 * @return string
	 */
	function thumb($url, $width, $height = null)
	{
		return Creolab\Image\ImageFacade::thumb($url, $width, $height);
	}
}

if ( ! function_exists('frag'))
{
	/**
	 * Display content fragment
	 * @param  string  $slug
	 * @param  string  $default
	 * @return string
	 */
	function frag($slug, $default = null)
	{
		$repo = app('Krustr\Repositories\Interfaces\FragmentRepositoryInterface');
		$frag = $repo->findBySlug($slug);

		if ($frag) return $frag->body;

		return $default;
	}
}
