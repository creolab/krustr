<?php namespace Krustr\Forms;

use Config, Form, Log, View;
use Krustr\Repositories\Entities\ChannelEntity;

/**
 * Base form class for content entries
 *
 * @author Boris Strahija <bstrahija@gmail.com>
 */
class EntryForm extends BaseForm implements FormInterface {

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

		// Grid row
		$html .= '<div class="row">';

		// Aside (field groups)
		$html .= $this->renderAside();

		// Start content fields
		$html .= '<div class="fields col-md-10">';

		// Hidden fields
		$html .= $this->hiddenFields();

		// Render each field
		foreach ($this->channel->groups as $groupName => $group)
		{
			// Open fieldset
			$html .= '<fieldset id="field-group-'.$groupName.'" class="field-group">';
			$html .= '<h3 class="field-group-title">'.$group->name.'</h3>';

			foreach ($group->fields as $name => $field)
			{
				// Get value
				$value = $this->entry ? $this->entry->$name : null;
				$class = $field->class;
				if ( ! $value and $this->entry) $value = $this->entry->field($name);

				// Instance of field object
				if (class_exists($class))
				{
					$fieldInstance = new $class($field, $value);

					// And fetch HTML for rendering
					$html .= $fieldInstance->render($value);
				}
				else
				{
					Log::error('[KRUSTR] [ENTRYFORM] Error when rendering form. Class by the name of "'.$class.'" for "'.$field->type.'" field type could not be found.');
				}
			}

			// Close the fieldset
			$html .= '</fieldset>';
		}

		// End content fields and grid row
		$html .= '</div></div>';

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
	 * Add hidden fields to form
	 *
	 * @return string
	 */
	public function hiddenFields()
	{
		$html  = Form::hidden('channel',  $this->channel->resource);
		$html .= Form::hidden('entry_id', $this->entry ? $this->entry->id : null);

		return $html;
	}

	/**
	 * Render sidebar for form
	 *
	 * @return string
	 */
	public function renderAside()
	{
		$html  = '<aside class="form-aside col-md-2">';

		// Render the groups
		$html .= View::make('krustr::entries._partial.field_groups')->withGroups($this->channel->groups);

		$html .= '</aside>';

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
