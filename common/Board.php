<?php
	class Board{
		public $board;
	
		//Ships
		public $ships;
		public $shipCounter;
	
		//Board dimension
		public $rows = 10;
		public $columns = 10;
	
		//Empty and hit cell numerical representation
		public $empty = 0;
		public $hit = 1;
	
		//Numerical representation of the ships in the board
		public $aircraft = 2;
		public $battleship = 3;
		public $frigate = 4;
		public $submarine = 5;
		public $minesweeper = 6;
	
		function __construct(/*$ships*/){
			$this->initBoard();
			//$this->ships = $ships;
			$this->setShipsCounter();
		}
	
		function __constructByJSON(array $data) {
			foreach($data as $key => $val) {
				if(property_exists(__CLASS__,$key)) {
					$this->$key = $val;
				}
			}
		}
	
		function initBoard(){
			$this->board = Array();
			for ($currRow = 0; $currRow < $this->rows; $currRow++){
				array_push($this->board, Array());
				for ($currCol = 0; $currCol < $this->columns; $currCol++){
					array_push($this->board[$currRow], $this->empty);
				}
			}
			//print_r($this->board);
		}
	
		/**
		 * Set ships counter to check if a ship has been destroyed
		 */
		function setShipsCounter(){
			$this->shipCounter = Array( $this->aircraft => 5,
										$this->battleship => 4,
										$this->frigate => 3,
										$this->submarine => 3,
										$this->minesweeper => 2);
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
		 *
		 * @param unknown $xPos
		 * @param unknown $yPos
		 * @return boolean
		 */
		function isCellEmpty($xPos, $yPos){
			if($this->board[$xPos][$yPos] < 1){
				return true;
			}
			return false;
		}
	
		/**
		 *
		 * @param unknown $shot
		 */
		function checkCollision($shot){
			$hitCell = $this->board[$shot->getX()][$shot->getY()];
				
			// if cell is empty, the player didn't hit a ship
			if($hitCell == $this->empty){
				return;
			}
				
			//subtract one from the hit ship
			$this->shipCounter[$hitCell]--;
				
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
			if( !$this->shipCounter[$this->aircraft] &&
					!$this->shipCounter[$this->battleship] &&
					!$this->shipCounter[$this->frigate] &&
					!$this->shipCounter[$this->submarine] &&
					!$this->shipCounter[$this->minesweeper] ){
						$shot->setIsWin(true);
						return true;
			}
			else{
				return false;
			}
		}
	}
?>



