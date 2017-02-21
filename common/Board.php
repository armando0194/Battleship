<?php
	class Board{
		public $board;
		public $ships;
	
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
		
		function __construct($board, $ships){
			$this->board = $board;
			$this->ships = $ships;
		}
		
		static function withRandomDeployment(){
			$instance = new self(null, null);
			$instance->initBoard();
			$instance-> randomDeployment();
			return $instance;
		}
		
		static function withEmptyBoard(){
			$instance = new self(null, null);
			$instance->initBoard();
			return $instance;
		}
		
		function placeShip($xPos, $yPos, $direction, $endPosition, $ship){
		
			$isShipPositionValid = true;
			if($direction) {
				if( $this->isCellOccupied($xPos, $yPos) ){
					return false;
				} else if ($xPos == $endPosition){
					$this->board[$xPos][$yPos] = $ship;
					return true;
				}
				else{
					$isShipPositionValid = $isShipPositionValid && $this->placeShip($xPos + 1, $yPos, $direction, $endPosition, $ship);
				}
			}
			else {
				if( $this->isCellOccupied($xPos, $yPos) ){
					return false;
				} else if ($yPos == $endPosition){
					$this->board[$xPos][$yPos] = $ship;
					return true;
				}
				else{
					$isShipPositionValid = $isShipPositionValid && $this->placeShip($xPos, $yPos + 1, $direction, $endPosition, $ship);
				}
			}
		
			if( $isShipPositionValid ){
				$this->board[$xPos][$yPos] = $ship;
				return true;
			}
			else{
				return false;
			}
		
		}
		
		/*
		 * Generates a random ship deployment and places the 
		 * ships in the board
		 */
		function randomDeployment(){
			$this->ships = array( self::AIRCRAFT => Ship::withNameAndSize("Aircraft Carrier",5),
								  self::BATTLESHIP => Ship::withNameAndSize("Battleship",4),
								  self::FRIGATE => Ship::withNameAndSize("Frigate",3),
								  self::SUBMARINE => Ship::withNameAndSize("Submarine",3),
								  self::MINESWEEPER => Ship::withNameAndSize("Minesweeper",2) );
				
			foreach ( $this->ships as $shipNumber => $ship ) {
				$result = false;
				while( !$result ){
					$direction = rand(0,1);
					if($direction){
						$offset = self::COLUMNS - ($ship->getSize() - 1);
						$xPos = rand(1, $offset);
						$yPos = rand(1, intval(self::ROWS) );
						$result = $this->placeShip($xPos, $yPos, $direction, $xPos + ($ship->getSize() - 1), $shipNumber);
					} else {
						$offset = self::ROWS - ($ship->getSize() - 1);
						$xPos = rand(1, intval(self::COLUMNS) );
						$yPos = rand(1, $offset);
						$result = $this->placeShip($xPos, $yPos, $direction, $yPos + ($ship->getSize() - 1), $shipNumber);
					}
		
					//echo "Ship: " . $shipSize . ", x: " . $yPos . ", y: " . $xPos . ", direction: " .  (($direction == true)? "horizontal, ": "vertical, ") . " result: " .( $result ) . PHP_EOL ;
				}
				$ship->setPositionAndDirection($xPos, $yPos, $direction);
			}
				
			//print_r($this->ships);
		}
		
		

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
		 *
		 * @param Play $shot -
		 */
		function fireAt($shot){
			$x = $shot->getX();
			$y = $shot->getY();
			if( $this->isCellEmpty($x, $y) || $this->isCellOccupied($x, $y) ){
				$this->checkCollision( $shot );
				$this->board[$x][$y] = self::HIT;
				print_r($this->ships);
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
			$this->ships[$hitCell]->reduceShipCounter();
		
			// if the counter is 0(ship has been destroyed), set sunk to true and check for winner
			if( $this->ships[$hitCell]->isShipSunk() ){
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
			foreach ( $this->ships as $shipNumber => $ship ) {
				if( !$ship->isShipSunk() ){
					return false;
				}
			}
			return true;
		}
		
		function isCellOccupied($xPos, $yPos){
			if( $this->board[$xPos][$yPos] > 1 ){
				return true;
			}
			return false;
		}
		
		/**
		 * Prints Board Testing purposes
		 */
		function printBoard(){
			for ($i = 1; $i <= self::ROWS; $i++){
				for ($j = 1; $j <= self::ROWS; $j++){
					echo $this->board[$i][$j] . " ";
				}
				echo PHP_EOL;
			}
				
		}
		
		function setShips($ships){
			$this->ships = $ships;
		}
	}
?>



