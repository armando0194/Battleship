<?php
include ("Strategy.php");
	
	//Sweep strategy
	class Sweep implements Strategy{
		private $lastShot;
		private $board;
		private $initialRow= 1;
		function __construct(){
			
		}
		
		public function move(){
			//checks if lastshot is empty, if it is, then give it the starting value (1,1)
			if( empty($lastShot) ){
				$lastShot = new Play( $initialRow, $initialRow );
				return $lastShot;
			}
			else{
				//if it is not empty, and is on the last cell
				//go to the first column of next row
				if( $lastShot.getX() == 10 ){
					$lastShot.setX( $initialRow );
					$lastShot.setY( $lastShot.getY() + 1 );
				}
				//if it is not in the last cell, then move 1 cell to the right.
				else{
					$lastShot.setX( $lastShot.getX() + 1 );
				}
			}
		}
	}
?>