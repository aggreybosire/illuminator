<?php

namespace Firalabs;

use Firalabs\Generator\Controller as GeneratorController;
use Firalabs\Generator\View as GeneratorView;
use Firalabs\Generator\Config as GeneratorConfig;
use Firalabs\Generator\Model as GeneratorModel;

/**
 * The main task for the Bob generator, commands are passed as
 * arguments to run()
 *
 * @package 	bob
 * @author 		Dayle Rees
 * @copyright 	Dayle Rees 2012
 * @license 	MIT License <http://www.opensource.org/licenses/mit>
 */
class Cli
{
	/**
	 * run() is the start-point of the CLI request, the
	 * first argument specifies the command, and sub-sequent
	 * arguments are passed as arguments to the chosen generator.
	 *
	 * @param $arguments array The command and its arguments.
	 * @return void
	 */
	public function run($arguments = array())
	{
		if (! count($arguments)) $this->_help();

		// setup ansi support
		Common::detect_windows();

		// assign the params
		$command = ($arguments[1] !== '') ? $arguments[1] : 'help';
		$args = array_slice($arguments, 2);
		$_SERVER['CLI'] = array();
		
		
		//For each arguments,
		foreach ($args as $key => $argument){
			
			//if is a options
			if(strpos($argument, '--') === 0){
				
				//Set option
				$_SERVER['CLI'][strtoupper(str_replace('--', '', $args[$key]))] = true;
				
				//Unset in the argument array;
				unset($args[$key]);
			}
			
		}

		switch($command)
		{
			case "controller":
			case "c":
				new GeneratorController($args);
				break;
			case "model":
			case "m":
				new GeneratorModel($args);
				break;
			case "config":
			case "co":
				new GeneratorConfig($args);
				break;
			case "view":
			case "v":
				new GeneratorView($args);
				break;
			default:
				$this->_help();
				break;
		}
	}

	/**
	 * Show a short version of the documentation to hint
	 * at command names, with an example.
	 *
	 * @return void
	 */
	private function _help()
	{
		Common::log('{w}Usage :');
		Common::log("\t{w}illuminator {c}<command> {g}[args] {y}[options ..]\n");
		Common::log('{w}Commands :');
		Common::log("\t{c}(c)      controller");
		Common::log("\t{c}(m)      model");
		Common::log("\t{c}(v)      view");
		Common::log("\t{c}(co)     config");
		Common::log("\n\n{w}Arguments :");
		Common::log("\t{g}--force\n\t{w}Force overwrite of existing files and folders.");
		Common::log("\t{g}--pretend\n\t{w}Show the result of a generation without writing to the filesystem.");																						
		exit();
	}
}
