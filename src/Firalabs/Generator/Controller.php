<?php
namespace Firalabs\Generator;

use Firalabs\Generator;
use Firalabs\Common;

/**
 * Generate a controller, its actions and associated views.
 */
class Controller extends Generator
{
	/**
	 * The view file extension, can also be blade.php
	 *
	 * @var string
	 */
	private $_view_extension = '.php';

	/**
	 * Start the generation process.
	 *
	 * @return void
	 */
	public function __construct($args)
	{
		parent::__construct($args);

		// we need a controller name
		if ($this->class == null)
			Common::error('You must specify a controller name.');

		// set switches
		$this->_settings();

		// start the generation
		$this->_controller_generation();

		// write filesystem changes
		$this->writer->write();
	}

	/**
	 * This method is responsible for generation all
	 * source from the templates, and populating the
	 * files array.
	 *
	 * @return void
	 */
	private function _controller_generation()
	{

		// set up the markers for replacement within source
		$markers = array(
			'#CLASS#'		=> $this->class_prefix.$this->class,
			'#LOWER#'		=> $this->lower,
			'#LOWERFULL#'	=> strtolower(str_replace('/','.', $this->class_path).$this->lower)
		);

		// loud our controller template
		$template = Common::load_template('controller/controller.tpl');

		// holder for actions source, and base templates for actions and views
		$actions_source 	= '';
		$action_template 	= Common::load_template('controller/action.tpl');
		$view_template 		= Common::load_template('controller/view.tpl');

		// loop through our actions
		foreach ($this->arguments as $action)
		{

			/*
			if(strstr($action, ':'))
			{
				$parts = explode(':', $action);

				if (count($parts) == 2)
				{
					$action = strtolower($parts[1]);
				}
			}*/

			// add the current action to the markers
			$markers['#ACTION#'] = $action;
			$markers['#ACTION_LOWER#'] = strtolower($action);

			// add the file to be created
			$this->writer->create_file(
				'View',
				$this->class_path.$this->lower.'/'.strtolower($action).$this->_view_extension,
				'generated/views/'.strtolower($this->class_path).$this->lower.'/'.strtolower($action).$this->_view_extension,
				Common::replace_markers($markers, $view_template)
			);

			// append the replaces source
			$actions_source .= Common::replace_markers($markers, $action_template);
		}

		// add a marker to replace the actions stub in the controller
		// template
		$markers['#ACTIONS#'] = $actions_source;

		// added the file to be created
		$this->writer->create_file(
			'Controller',
			$markers['#CLASS#'].'_Controller',
			'generated/controllers/'.$this->class_path.$this->standard.'.php',
			Common::replace_markers($markers, $template)
		);

		/*
		$this->writer->append_to_file(
			$this->bundle_path.'routes.php',
			"\n\n// Route for {$markers['#CLASS#']}_Controller\nRoute::controller('{$markers['#LOWERFULL#']}');"
		);
		*/
	}

	/**
	 * Alter generation settings from artisan
	 * switches.
	 *
	 * @return void
	 */
	private function _settings()
	{
		if(Common::config('blade')) $this->_view_extension = '.blade.php';
	}
}
