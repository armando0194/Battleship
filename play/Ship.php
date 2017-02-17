<?php
	class Ship{
		public $name;
		public $xPos;
		public $yPos;
		public $direction;
		
		function __construct($name, $xPos, $yPos, $direction)
		{ 
			$this->name = $name;
			$this->xPos = $xPos;
			$this->yPos = $yPos;
			$this->direction = $direction;	
		}
	}
?>