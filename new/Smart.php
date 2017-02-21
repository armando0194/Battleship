<?php
include "../common/Shot.php";
include "../common/Board.php";

//COment
	class Smart implements Strategy{
		public $lastShot;
		
		public function move($board){
			if(empty($lastSHot)){
				$lastShot = new Shot(1,1);
				$board -> fireAt($lastShot);
				return $lastShot;
			}else if(!$lastShot -> getIsHit()){
				$xPos = $lastShot -> getX();
				$yPos = $lastShot -> getY();
				if($Xpos < $board::COLUMNS -2){ //skip one place en shoot
					$lastShot = new Shot($xPos+2 , $yPos);
					$board -> fireAt($lastShot);
					return $lastShot;
				}else{
					$lastShot = new Shot($xPos+2 , $yPos+1); //skip one place and shoot one row down
					$board -> fireAt($lastShot);
					return $lastShot;
				}	
			}//end last shot did not hit
			else{
				$xPos = $lastShot -> getX();
				$yPos = $lastShot -> getY();
				if($lastShot -> getIsSunk()){
					$lastShot = new Shot($xPos+2 , $yPos);
					$board -> fireAt($lastShot);
					return $lastShot; //if ship is sunk continue going right
				}else if($lastShot -> getIsSHit() && $xPos < $Board::COLUMNS){
					if(!$board -> isCellEmpty($xPos-1,$yPos) ){
						$lastShot = new Shot($xPos-1 , $yPos);
						$board -> fireAt($lastShot);
						return $lastShot;
					}else{
						$lastShot = new Shot($xPos+1 , $yPos);
						$board -> fireAt($lastShot);
						return $lastShot;
					}
				}else{
					$lastShot = new Shot($xPos , $yPos+1);
					$board -> fireAt($lastShot);
					return $lastShot;
				}
				
			}
		}
	}
?>