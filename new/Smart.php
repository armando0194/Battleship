<?php
include "Strategy.php";

//COment
	class Smart implements Strategy{
		public $lastShot;
		
		public function move($board){
			if(empty($this->lastShot)){
				$this->lastShot = new Shot(1,1);
				$board -> fireAt($this->lastShot);
				return $this->lastShot;
			}else if(!$this->lastShot -> getIsHit()){
				$xPos = $this->lastShot -> getX();
				$yPos = $this->lastShot -> getY();
				if($Xpos < $board::COLUMNS -2){ //skip one place en shoot
					$this->lastShot = new Shot($xPos+2 , $yPos);
					$board -> fireAt($this->lastShot);
					return $this->lastShot;
				}else{
					$this->lastShot = new Shot($xPos+2 , $yPos+1); //skip one place and shoot one row down
					$board -> fireAt($this->lastShot);
					return $this->lastShot;
				}	
			}//end last shot did not hit
			else{
				$xPos = $this->lastShot -> getX();
				$yPos = $this->lastShot -> getY();
				if($this->lastShot -> getIsSunk()){
					$this->lastShot = new Shot($xPos+2 , $yPos);
					$board -> fireAt($this->lastShot);
					return $this->lastShot; //if ship is sunk continue going right
				}else if($this->lastShot -> getIsSHit() && $xPos < $Board::COLUMNS ){
					if(!$board -> isCellEmpty($xPos-1,$yPos) ){
						$this->lastShot = new Shot($xPos-1 , $yPos);
						$board -> fireAt($this->lastShot);
						return $this->lastShot;
					}else{
						$this->lastShot = new Shot($xPos+1 , $yPos);
						$board -> fireAt($this->lastShot);
						return $this->lastShot;
					}
				}else{
					$this->lastShot = new Shot($xPos+2 , $yPos+1);
					$board -> fireAt($this->lastShot);
					return $this->lastShot;
				}
				
			}
		}
	}
?>