<?php
	class Shot{
		public $x;
		public $y;
		public $isHit;   // hit a ship?
		public $isSunk;  // sink a ship?
		public $isWin;   // game over?
		public $ship;
	
		function __construct($x, $y){
			$this->x = $x;   // hit a ship?
			$this->y = $y;
			$this->isHit = false;   // hit a ship?
			$this->isSunk = false;  // sink a ship?
			$this->isWin = false;
		}
	
		function getX(){
			return $this->x;
		}
	
		function getY(){
			return $this->y;
		}
	
		function setIsHit($isHit){
			$this->isHit = $isHit;
		}
	
		function setIsSunk($isSunk){
			$this->isSunk = $isSunk;
		}
	
		function setIsWin($isWin){
			$this->isWin = $isWin;
		}
	}
?>