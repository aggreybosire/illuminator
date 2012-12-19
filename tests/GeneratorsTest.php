<?php

use Firalabs\Generator\Controller as GeneratorController;
use Firalabs\Generator\View as GeneratorView;

/**
 * Unit tests for generator
 * @author maxime.beaudoin
 *
 */
class GeneratorsTest extends PHPUnit_Framework_TestCase
{

	public function testExample()
	{
		
		/*
		new GeneratorController(array(
			'Api.ControllerName',
			'getIndex',
			'postIndex'
		));*/
		
		new GeneratorView(array(
			'admin.index',
		));
	
	}

}