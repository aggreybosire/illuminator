<?php

use Firalabs\Generator\Controller as GeneratorController;
use Firalabs\Generator\View as GeneratorView;
use Firalabs\Generator\Config as GeneratorConfig;
use Firalabs\Generator\Model as GeneratorModel;

/**
 * Unit tests for generator
 * @author maxime.beaudoin
 *
 */
class GeneratorsTest extends PHPUnit_Framework_TestCase
{

	public function testExample()
	{
		
		new GeneratorController(array(
			'Api.ControllerName',
			'getIndex',
			'postIndex'
		));
		
		
		new GeneratorView(array(
			'admin.index',
		));
		
		
		new GeneratorConfig(array(
			'application',
			'config_1',
			'config_2'
		));
		
		new GeneratorModel(array(
			'user',
			'has_many:task',
			'belongs_to:profile'
		));
	
	}

}