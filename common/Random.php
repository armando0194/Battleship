<?php
include ("Strategy.php");

	//Random strategy
	class Random  implements Strategy{
		public function move($shot){
			$test= new Board();
			$shot = new Play(rand(1,10), rand(1,10));

			//if the cell is empty or there is a ship, then make another random shot.
			while(!$test->isCellEmpty($shot->getX(),$shot->getX()) ){		
				$shot->setX(rand(1,10));
				$shot->setY(rand(1,10));
			}
			
			return $shot;
		}
	}
?>