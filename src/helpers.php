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
	function theme_assets($name, $addAssets = array(), $addOptions = array())
	{
		$collection = Config::get('theme::assets.' . $name);

		// Get assets and filters
		if ($collection)
		{
			$assets  = (array) array_get($collection, 'assets');
			$filters = (array) array_get($collection, 'filters');

			// Merge 'em
			if ($addAssets  and is_array($addAssets))                        $assets  = array_merge($assets, $addAssets);
			if ($addOptions and is_array(array_get($addOptions, 'filters'))) $filters = array_merge($filters, array_get($addOptions, 'filters'));

			// Return tags
			return app('assets')->assets($name, $assets, $filters);
		}
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

if ( ! function_exists('theme_assets'))
{
	/**
	 * Include a theme asset
	 *
	 * @param  string $path
	 * @return string
	 */
	function theme_assets($id = 'default.css', $assets = array(), $filters = array())
	{
		$themeAssets = array();

		foreach ($assets as $asset)
		{
			$themeAssets[] = $asset;
		}

		return assets($id, $themeAssets, $filters);
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
		if (isset($template_class)) return $template_class;
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
