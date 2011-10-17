<?php
//
// php 5.4 traits may be better for this sort of behaviour!
//

abstract class mgkbase {

	public $__closures = array();
	public $name = "sample\n";

	public function __set($name, $val) {
		if($val instanceof closure)
		{
			$this->__closures[$name] = $val;
		}
	}

	public function __get($name)
	{
		if(array_key_exists($name, $this->__closures))
		{
			return $this->__closures[$name];
		}
	}

	public function __call($name, $args)
	{
		if(array_key_exists($name, $this->__closures))
		{
			$c = $this->__closures[$name];
			$c($args);
		}
	}

}

class foo extends mgkbase{}

$y = new foo();
$y->showNow = function() use ($y) { 
	echo $y->name;
	echo "now=".time()."\n";
};

$y->showNow();
