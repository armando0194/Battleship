<?php
	class Ship{
		public $name;
		public $xPos;
		public $yPos;
		public $direction;
		public $size;
		public $hitCounter;
		
		function __construct($name, $size, $xPos, $yPos, $direction)
		{ 
			$this->name = $name;
			$this->size = $size;
			$this->xPos = $xPos;
			$this->yPos = $yPos;
			$this->direction = $direction;	
			$this->hitCounter = $size;
		}
		
		static function withNameAndSize($name, $size){
			$instance =  new self($name, $size, null, null, null);
			return $instance;
		}
		function setPositionAndDirection($xPos, $yPos, $direction){
			$this->xPos = $xPos;
		 	$this->yPos = $yPos;
		 	$this->direction = $direction;
		}
		
		function reduceShipCounter(){
			$this->hitCounter--;
		}
		function getSize(){
			return $this->size;
		}
		function isShipSunk(){
			return ($this->hitCounter == 0) ? true : false;
		}
	}
?>