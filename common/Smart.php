<?php
	class Smart extends Strategy{
		public $isShipFound;      // flag that is set when a ship is found
		public $potentialShipLoc; // potential ship location
		
		/**
		 * Constructor
		 * calls the generatePossibleMoves method from a parent
		 */
		function __construct( $possibleMoves = false, $isShipFound = false, $potentialShipLoc = false ){
			if(empty($possibleMoves)){
				$this->isShipFound = false;
				$this->potentialShipLoc = array();
				parent::generatePossibleMoves();
			} else {
				$this->isShipFound = $isShipFound;
				$this->potentialShipLoc = $potentialShipLoc;
				parent::setPossibleMoves($possibleMoves);
			}	
		}

		/**
		 * Generates a computer move
		 */
		function move($board){
			$possibleMoves = parent::getPossibleMoves();
			
			if(empty($this->potentialShipLoc)){
			// if the stack is empty, a ship has not been found
				$this->isShipFound = false;
			}
		
			if( $this->isShipFound ){
			//if a ship was found try to shoot at the surrounding cells
				$shot = array_pop( $this->potentialShipLoc);
			} else{
			//otherwise, generate random value and check if a ship was hit
				$randomKey = array_rand( $possibleMoves );
				$shot = $possibleMoves[$randomKey];
				parent::removeShot($randomKey);
			}		
			
			// if the cell contains a ship, set flag and fill potential moves
			if( $board->isCellOccupied($shot->getX(), $shot->getY()) ){
				$this->isShipFound = true;
				$this->generatePotentialMoves( $shot, $possibleMoves);
			}

			$board->fireAt($shot);
			return $shot;
		}
		
		/**
		 * Adds surronding cells to the potential ship location
		 * @param Shot $shot - computer move
		 * @param Shot Array $possibleMoves - possible moves array
		 */
		function generatePotentialMoves($shot, $possibleMoves){
			$cell = (($shot->getX() - 1) * 10) + ($shot->getY() - 1);
			
			// if the cell to the left exists or hasnt been hit, add it to potential move
			if( $shot->getY() > 1  && !empty($possibleMoves[$cell-1]) ) {
				array_push($this->potentialShipLoc, $possibleMoves[$cell-1]);
				parent::removeShot($cell-1);
			}
			
			// if the cell to the right exists or hasnt been hit, add it to potential move
			if( $shot->getY() < 10 && !empty($possibleMoves[$cell+1]) ) {
				array_push($this->potentialShipLoc, $possibleMoves[$cell+1]);
				parent::removeShot($cell+1);
			}
			
			// if the cell above exists or hasnt been hit, add it to potential move
			if( $shot->getX() > 1 && !empty($possibleMoves[$cell-10]) ) {
				array_push($this->potentialShipLoc, $possibleMoves[$cell-10]);
				parent::removeShot($cell-10);
			}
			
			// if the cell below exists or hasnt been hit, add it to potential move
			if( $shot->getX() < 10  && !empty($possibleMoves[$cell+10]) ) {
				array_push($this->potentialShipLoc, $possibleMoves[$cell+10]);
				parent::removeShot($cell+10);
			}		
		}		
	}
?>