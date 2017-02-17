<?php
	class Board{
		public $board;
	
		//Ships
		public $shipCounter;
	
		//Board dimension
		const ROWS = 10;
		const COLUMNS = 10;
	
		//Empty and hit cell numerical representation
		const EMPTYCELL = 0;
		const HIT = 1;
	
		//Numerical representation of the ships in the board
		const AIRCRAFT = 2;
		const BATTLESHIP = 3;
		const FRIGATE = 4;
		const SUBMARINE = 5;
		const MINESWEEPER = 6;
	
		function __construct($board){
			if( empty($board) ){
				$this->initBoard();
			}
			else{
				$this->board = $board;
			}
			$this->setShipsCounter();
		}
	
		/**
		 * 
		 */
		function initBoard(){
			$this->board = Array();
			for ($currRow = 0; $currRow < self::ROWS; $currRow++){
				array_push($this->board, Array());
				for ($currCol = 0; $currCol < self::COLUMNS; $currCol++){
					array_push($this->board[$currRow], self::EMPTYCELL);
				}
			}
		}
	
		/**
		 * Set ship counters to check if a ship has been destroyed
		 */
		function setShipsCounter(){
			$this->shipCounter = Array( self::AIRCRAFT => 5,
										self::BATTLESHIP => 4,
										self::FRIGATE => 3,
										self::SUBMARINE => 3,
										self::MINESWEEPER => 2);
		}
		/**
		 * Set ship counters to check if a ship has been destroyed
		 */
		function setShipsCounter(){
			$this->shipCounter = Array( AIRCRAFT => 5,
					BATTLESHIP => 4,
					FRIGATE => 3,
					SUBMARINE => 3,
					MINESWEEPER => 2);
		}
		
		/**
		 *
		 * @param Play $shot -
		 */
		function fireAt($shot){
			$x = $shot->getX();
			$y = $shot->getY();
		
			if( !$this->isCellEmpty($x, $y) ){
				$this->checkCollision($shot);
				$this->board[$x][$y] = $this->hit;
			}
		}
		
		/**
		 * Determines if the cell is empty
		 * @param unknown $xPos - x coordinate
		 * @param unknown $yPos - y coordinate
		 * @return boolean true if cell is empty, false otherwise
		 */
		function isCellEmpty($xPos, $yPos){
			if($this->board[$xPos][$yPos] < 1){
				return true;
			}
			return false;
		}
		
		/**
		 * Checks if a shot has hit a ship or not
		 * @param Play $shot - player's shot
		 */
		function checkCollision($shot){
			$hitCell = $this->board[$shot->getX()][$shot->getY()];
		
			// if cell is empty, the player didn't hit a ship
			if($hitCell == $this->empty){
				return;
			}
		
			//subtract one from the hit ship
			$this->shipCounter[$hitCell]--;
		
			// if the counter is 0(ship has been destroyed), set sunk to true and check for winner
			if(!$this->shipCounter[$hitCell]){
				$shot->setIsSunk(true);
				$this->checkWinner($shot);
			}
		
			$shot->setIsHit(true);
		}
		
		/**
		 * Checks if all the ships have been destroyed
		 * @return boolean
		 */
		function checkWinner($shot){
		
			// if the ship counters are equal to zero, the current player won
			if( !$this->shipCounter[AIRCRAFT] &&
					!$this->shipCounter[BATTLESHIP] &&
					!$this->shipCounter[FRIGATE] &&
					!$this->shipCounter[SUBMARINE] &&
					!$this->shipCounter[MINESWEEPER] ){
						$shot->setIsWin(true);
						return true;
			}
			else{
				return false;
			}
		}
	}
?>



