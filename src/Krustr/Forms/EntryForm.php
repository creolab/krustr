<?php namespace Krustr\Forms;

use Config, Form, View;
use Krustr\Repositories\Entities\ChannelEntity;

/**
 * Base form class for content entries
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class EntryForm {

	/**
	 * Entry channel
	 *
	 * @var array
	 */
	protected $channel;

	/**
	 * Content entry object
	 *
	 * @var array
	 */
	protected $entry;

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
	 * @param string $channel
	 * @param mixed  $entry
	 */
	public function __construct(ChannelEntity $channel, $entry = null)
	{
		// Assign channel
		$this->channel = $channel;

		// Assign entry if exists
		$this->entry = $entry;
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

		// Render each field
		foreach ($this->channel->fields as $field)
		{
			// Get value
			$key   = $field->name;
			$value = $this->entry ? $this->entry->$key : null;
			if ( ! $value and $this->entry) $value = $this->entry->field($key);

			// And fetch HTML for rendering
			$html .= $field->render($value);
		}

		// Close the form
		$html .= $this->closeForm();

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
		$resource = $this->channel->resource;
		$route    = $this->entry ? admin_route('content.' . $resource . '.update', $this->entry->id) : admin_route('content.' . $resource . '.store');
		$method   = $this->entry ? 'put' : 'post';

		// Generate the tag
		$html = Form::open(array('class' => 'form-vertical entry-form', 'url' => $route, 'method' => $method));

		return $html;
	}

	/**
	 * Close the form HTML and add actions
	 *
	 * @return string
	 */
	public function closeForm()
	{
		// Add form actions
		$html = View::make('krustr::entries._partial.toolbar')->withEntry($this->entry);

		// Close the form
		$html .= Form::close();

		return $html;
	}

}
