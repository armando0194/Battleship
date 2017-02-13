<?php

	class Board{
		public $board;
		public $ships;
		public $rows = 10;
		public $columns = 10;
		public $empty = 0;
		public $hit = 1;
		
		function __construct(){
			$this->initBoard();
		}
		
		function initBoard(){
			$this->board = Array();
			for ($currRow = 0; $currRow < $this->rows; $currRow++){
				array_push($this->board, Array());
				for ($currCol = 0; $currCol < $this->columns; $currCol++){
					array_push($this->board[$currRow], $this->empty);
				}
			}
			print_r($this->board);
		}
		
		function fireAt($shot){
			if( isCellEmpty($shot->getX(), $shot->getY()) ){
				checkCollision($shot);
				$this->board[$shot->getX()][$shot->getY()] = $hit;
			}
		}
		
		function isCellEmpty($xPos, $yPos){
			if($this->board[$xPos][$yPos] < 1){
				return true;
			}
			return false;
		}
		
		function checkCollision($shot){
			$hitCell = $this->board[$shot->getX()][$shot->getY()];
			
			if($hitCell == 0){
				return;
			}
		}
		
	}
	
	class Shot{
		public $x;
		public $y;
		public $isHit;   // hit a ship?
		public $isSunk;  // sink a ship?
		public $isWin;   // game over?
		public $ship;
		
		function __construct(){
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
	
	$test = new Board();
	/**
	 *   0 0 0 0 0 0 0 0 0 0 0 
	 *   0 0 0 0 0 2 0 0 0 0 0 
	 *   0 0 0 0 0 2 0 0 0 0 0 
	 *   0 0 0 0 0 2 3 3 0 0 0 
	 *   0 0 0 0 0 0 0 0 0 0 0 
	 *   0 0 0 0 0 0 0 0 0 0 0 
	 *   0 0 0 0 0 0 0 0 0 0 0 
	 *   
	 */
?>



