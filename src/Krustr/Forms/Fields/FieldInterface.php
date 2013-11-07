<?php namespace Krustr\Forms\Fields;

use View;

/**
 * Base class for various content fields
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */

interface FieldInterface {

	public function render($value);
	public function save($data);
	public function definition();

}
