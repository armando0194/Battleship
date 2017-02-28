<?php
	abstract class Strategy
	{
		public $possibleMoves; //array containing all the possible moves
		
		/**
		 * Force Extending class to define this method
		 * @param Board $board - board object
		 */
		abstract protected function move($board);
		
		/**
		 * Generates all the possible moves the computer can make, and
		 * stores them in an array
		 */
		public function generatePossibleMoves(){
			$this->possibleMoves = array();
			// Iterates through all the possible moves
			for ($currCol = 0; $currCol < 10; $currCol++){
				for ($currRow = 0; $currRow < 10; $currRow++){
					$this->possibleMoves[($currRow * 10) + $currCol] = new Shot($currRow+1, $currCol+1);
				}
			}
		}
		
		/**
		 * Getter for $possibleMoves
		 */
		public function getPossibleMoves(){
			return $this->possibleMoves;
		}
		
		/**
		 * Setter for $possibleMoves
		 */
		public function setPossibleMoves($possibleMoves){
			$this->possibleMoves = $possibleMoves;
		}
		
		public function removeShot($key){
			unset( $this->possibleMoves[$key] );
		}
	}
?>