<?php namespace Krustr\Services\Theme;

use View;

/**
 * Some helpers used by the theme
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class Theme {

	/**
	 * Return currently loaded template
	 * @return string
	 */
	public function template()
	{
		return View::shared('template', 'none');
	}

	/**
	 * Return class for current template
	 * This is used for marking the HTML body tag
	 * @return string
	 */
	public function templateClass()
	{
		return 'tpl-' . $this->template();
	}

}
