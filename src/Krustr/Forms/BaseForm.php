<?php namespace Krustr\Forms;

use Config, Form, View;
use Krustr\Repositories\Entities\FieldEntity;
/**
 * Base form class for content entries
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class BaseForm implements FormInterface {

	/**
	 * Content entry object
	 *
	 * @var array
	 */
	protected $item;

	/**
	 * Action URL
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * Container holding all field objects
	 *
	 * @var array
	 */
	protected $fields = array();

	/**
	 * Container holding all field groups
	 *
	 * @var array
	 */
	protected $groups = array();

	/**
	 * Initialize new form object
	 *
	 * @param array  $fields
	 * @param mixed  $item
	 */
	public function __construct($item = null, $options = array())
	{
		// Assign entry if exists
		$this->item = $item;

		// Options
		$route = array_get($options, 'route');
		if (is_array($route)) $route = route(Config::get('krustr::backend_url') . '.' . $route[0], array_get($route, 1));
		else                  $route = route(Config::get('krustr::backend_url') . '.' . $route);
		$this->url = $route ? $route : array_get($options, 'url');
	}

	/**
	 * Renders the form
	 *
	 * @return string
	 */
	public function render()
	{
		// Start
		$html = $this->openForm();

		// Hidden fields
		$html .= $this->hiddenFields();

		// Render each field
		foreach ($this->fields as $name => $field)
		{
			$html .= $this->renderField($field, $name);
		}

		// Close the form
		$html .= $this->closeForm();

		return $html;
	}

	/**
	 * Render a single field
	 * @param  string $type
	 * @param  mixed $value
	 * @return string
	 */
	public function renderField($field, $name)
	{
		$html  = '';
		$value = $this->item ? $this->item->$name : null;
		$type  = app('krustr.fields')->get($field['type']);

		if ($type)
		{
			// Field entity
			$field = new FieldEntity(array_merge($field, $type->data));
			$class = $field->class;

			// Instance of field object
			$fieldInstance = new $class($field, $value);

			// // And fetch HTML for rendering
			$html .= $fieldInstance->render($value);
		}

		return $html;
	}

	/**
	 * Open the form tag with proper URL and method
	 *
	 * @return string
	 */
	public function openForm()
	{
		// Create resource form route
		$method   = $this->item  ? 'put' : 'post';

		// Generate the tag
		$html = Form::open(array('class' => 'form-vertical entry-form', 'url' => $this->url, 'method' => $method));

		return $html;
	}

	/**
	 * Add hidden fields to form
	 *
	 * @return string
	 */
	public function hiddenFields()
	{

	}

	/**
	 * Close the form HTML and add actions
	 *
	 * @return string
	 */
	public function closeForm()
	{
		$html = '<div>' . Form::submit('Save', array('class' => 'btn btn-primary')) . '</div>';

		// Close the form
		$html .= Form::close();

		return $html;
	}

}
