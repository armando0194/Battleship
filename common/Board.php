<?php
	class Board{
		public $board;
		public $ships;
	
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
	
		public $trackback = false;
		
		function __construct($board,$ships){
			if( empty($board) ){
				$this->initBoard();
				$this-> randomDeployment();
			}
			else{
				$this->board = $board;
				$this->ships = $ships;
			}
			$this->setShipsCounter();
		}
		
		function placeShip($xPos, $yPos, $direction, $endPosition, $ship){
		
			$this->trackback = true;
			if($direction) {
				if( $this->isCellOccupied($xPos, $yPos) ){
					return false;
				} else if ($xPos == $endPosition){
					//$this->board[$xPos][$yPos] = $ship;
					return true;
				}
				else{
					$this->trackback = $this->trackback && $this->placeShip($xPos + 1, $yPos, $direction, $endPosition, $ship);
				}
			}
			else {
				if( $this->isCellOccupied($xPos, $yPos) ){
					return false;
				} else if ($yPos == $endPosition){
					//$this->board[$xPos][$yPos] = $ship;
					return true;
				}
				else{
					$this->trackback = $this->trackback && $this->placeShip($xPos, $yPos + 1, $direction, $endPosition, $ship);
				}
			}
		
			if( !$this->trackback ){
				$this->board[$xPos][$yPos] = $ship;
			}
		
		}
		/*
		 * Generate a random ship deployment in a board
		 */
		function randomDeployment(){
			//$deployment= array(  new Ship("Aircraft+carrier",1,6,false), new Ship("Battleship",7,5,true), new Ship("Frigate",2,1,false), new Ship("Submarine",9,6,false), new Ship("Minesweeper",10,9,false) );
			for($shipSize = 2; $shipSize <= 5; $shipSize++){
				$direction = rand(0,1);
				//do{
					if($direction){
						$offset = self::COLUMNS - ($shipSize - 1);
						$xPos = rand(1, $offset);
						$yPos = rand(1, intval(self::ROWS) );
						$this->placeShip($xPos, $yPos, $direction, $xPos + ($shipSize-1), $shipSize);
					} else {
						$offset = self::ROWS - ($shipSize - 1);
						$xPos = rand(1, intval(self::COLUMNS) );
						$yPos = rand(1, $offset);
						$this->placeShip($xPos, $yPos, $direction, $yPos + ($shipSize-1), $shipSize);
					}
					
				//}while( !$this->trackback );
				
				//placeShipOnBoard($direction,$xPos,$yPos,$shipSize);
				//$this->printBoard();
			}
		}
		/*
		function placeShipOnBoard($direction,$xPos,$yPos,$shipSize){
			for($start=0;$start < $shipSize ; $start++){
				if($direction){
					$this->board[$xPos + $start][$yPos] = $shipSize;
				}else{
					$this->board[$xPos][$yPos + $start] = $shipSize;
				}
			}
		}*/
		/**
		 * 
		 */
		function initBoard(){
			$this->board = Array();
			for ($currRow = 1; $currRow <= self::ROWS; $currRow++){
				$this->board[$currRow] = Array();
				for ($currCol = 1; $currCol <= self::COLUMNS; $currCol++){
					$this->board[$currRow][$currCol] = self::EMPTYCELL;
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
		 *
		 * @param Play $shot -
		 */
		function fireAt($shot){
			$x = $shot->getX();
			$y = $shot->getY();
		
			if( $this->isCellEmpty($x, $y) ){
				$this->checkCollision( $shot );
				$this->board[$x][$y] = self::HIT;
				return true;
			}
			return false;
		}
		
		/**
		 * Determines if the cell is empty
		 * @param unknown $xPos - x coordinate
		 * @param unknown $yPos - y coordinate
		 * @return boolean true if cell is empty, false otherwise
		 */
		function isCellEmpty($xPos, $yPos){
			if($this->board[$xPos][$yPos] != 1){
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
			if($hitCell == self::EMPTYCELL){
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
		
		function isCellOccupied($xPos, $yPos){
			if( $this->board[$xPos][$yPos] > 1 ){
				return true;
			}
			return false;
		}
		
		function printBoard(){
			for ($i = 0; $i < self::ROWS; $i++){
				for ($j = 0; $j < self::ROWS; $j++){
					echo $this->board[$i][$j] . " ";
				}
				echo PHP_EOL;
			}
				
		}
	}
?>



