<?php

/**
 * BaseController
 */
abstract class BaseController {
	/**
	 * Does the request have the $name parameter in it?
	 * 
	 * @param string $name 
	 * @return boolean
	 */
	public function hasRequestParameter($name) {
		// Magic
	}

	/**
	 * Get a variable from request
	 *
	 * Eg.
	 *
	 * /controller/action?name=Fred
	 *
	 * $name = $this->getRequestParameter('name');
	 * $age = $this->getRequestParameter('age', 'missing');
	 *
	 * echo $name; // echos "Fred"
	 * echo $age; // echos "missing"
	 *
	 * @param string $name
	 * @param string $default
	 * @return string
	 */
	public function getRequestParameter($name, $default=null) {
		// Magic
	}

	/**
	 * Assign a view variable
	 *
	 * When you assign a variable with this it appears in the scope of the view
	 * template file. 
	 * 
	 * Eg. $this->assignViewVariable('foo', 'bar') in the controller means we
	 * can do this in the template:
	 *
	 * echo $foo; // echos 'bar'
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function setViewVariable($name, $value) {
		// Magic
	}

	/**
	 * Render a view file
	 *
	 * @param string $name
	 * @return string
	 */
	public function renderView($name) {
		// Magic
	}
}
