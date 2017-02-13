<?php

	class Board{
		public $board;
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
				$this->board[$shot->getX()][$shot->getY()] = $hit;
			}
			checkCollision($shot);
		}
		
		function isCellEmpty($xPos, $yPos){
			if($this->board[$xPos][$yPos] < 1){
				return true;
			}
			return false;
		}
		
		function checkCollision($shot){
			
		}
		
	}
	
	class Shot{
		public $x;
		public $y;
		public $isHit;   // hit a ship?
		public $isSunk;  // sink a ship?
		public $isWin;   // game over?
		public $ship;
		
		function getX(){
			return $this->x;
		}
		
		function getY(){
			return $this->y;
		}	
	}
	
	$test = new Board();
?>