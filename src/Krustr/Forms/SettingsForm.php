<?php namespace Krustr\Forms;

use Form, View;
use Krustr\Repositories\Collections\SettingGroupCollection;

class SettingsForm extends BaseForm implements FormInterface {

	protected $settings;

	/**
	 * Initialize new form object
	 * @param string $channel
	 * @param mixed  $entry
	 */
	public function __construct(SettingGroupCollection $settings = null, $options = array())
	{
		$this->settings = $settings;

		parent::__construct(null, $options);
	}

	/**
	 * Renders the form
	 * @return string
	 */
	public function render()
	{
		View::share('settings', $this->settings);

		// Start
		$html = $this->openForm();

		// Grid row
		$html .= '<div class="row">';

		// Aside (field groups)
		$html .= $this->renderAside();

		// Start content fields
		$html .= '<div class="fields col-md-10">';

		// Render each field
		foreach ($this->settings as $groupName => $group)
		{
			// Open fieldset
			$html .= '<fieldset id="field-group-'.$groupName.'" class="field-group">';
			$html .= '<h3 class="field-group-title">'.$groupName.'</h3>';

			$html .= '<div class="form-group">
			    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
			    <div class="col-sm-10">
			      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
			    </div>
			  </div>';

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
	 * Render settings group picker
	 * @return string
	 */
	public function renderAside()
	{
		$html  = '<aside class="form-aside col-md-2">';

		// Render the groups
		$html .= View::make('krustr::settings._partial.groups')->withGroups($this->settings);

		$html .= '</aside>';

		return $html;
	}

	/**
	 * Open the form tag with proper URL and method
	 * @return string
	 */
	public function openForm()
	{
		// Create resource form route
		$method = 'put';

		// Generate the tag
		$html = Form::open(array('class' => 'form-horizontal entry-form', 'url' => $this->url, 'method' => $method));

		return $html;
	}

}
