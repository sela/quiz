<?php
class SomeClass
{
	protected $_someMember;
	public function __construct()
	{
		$this->_someMember = 1;
	}

	public static function getSomethingStatic()
	{
		return $this->_someMember * 5; 
	}
}
