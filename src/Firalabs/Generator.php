<?php

namespace Firalabs;

/**
 * Superclass to process command arguments for
 * generator classes.
 *
 * @package 	bob
 * @author 		Dayle Rees
 * @copyright 	Dayle Rees 2012
 * @license 	MIT License <http://www.opensource.org/licenses/mit>
 */
class Generator
{

	/**
	 * The arguments as passed to the build script.
	 *
	 * @var array
	 */
	protected $args;

	/**
	 * The class name in unaltered case.
	 *
	 * @var string
	 */
	protected $standard;

	/**
	 * The class name in lowercase.
	 *
	 * @var string
	 */
	protected $lower;

	/**
	 * The classified class name.
	 *
	 * @var string
	 */
	protected $class;

	/**
	 * The class prefix for multi level assets.
	 *
	 * @var string
	 */
	protected $class_prefix = '';

	/**
	 * The class path for multi level assets.
	 *
	 * @var string
	 */
	protected $class_path = '';

	/**
	 * The extra arguments, passed after class.
	 *
	 * @var array
	 */
	protected $arguments;

	/**
	 * Used to write or append new files and folders.
	 *
	 * @var Writer
	 */
	protected $writer;

	/**
	 * Determine class names, identifiers and arguments based on the args
	 * passed by the build script.
	 *
	 * @param array Arguments to the build script.
	 * @return void
	 */
	public function __construct($args)
	{
		// we need a writer object for file system changes
		$this->writer = new Writer();
		
		// set default args
		$this->args = $args;
		
		// if we got an argument
		if (isset($args [0])) {
			
			// if we have a multi-level path
			if (strstr($args [0], '.')) {
				
				//Generate parts
				$parts = explode('.', $args [0]);
				
				// form the class prefix as in Folder_Folder_Folder_
				$this->class_prefix = implode('_', array_slice($parts, 0, - 1)) . '_';
				
				// form the path to the class
				$this->class_path = implode('/', array_slice($parts, 0, - 1)) . '/';
				
				// unaltered case class
				$this->standard = $parts [count($parts) - 1];
				
				// lowercase class
				$this->lower = strtolower($parts [count($parts) - 1]);
				
				// get our class name
				$this->class = $parts [count($parts) - 1];
			} else {
				// unaltered case class
				$this->standard = $args [0];
				
				// lowercase class
				$this->lower = strtolower($args [0]);
				
				// get our class name
				$this->class = $args [0];
			
			}
		}
		
		// pass remaining arguments
		$this->arguments = array_slice($args, 1);
	}
}
