<?php
class Player{
	public $board;
	
	
	function __construct($board){
		$this->board = $board;
		
	}
	
	function getBoard(){
		return $this->board;
	}
	
	function toJson()
	{
		return json_encode($this);
	}
	
}

class ComputerPlayer extends Player  {
	public $strategy;
	
	function __construct($strategy, $board){
		parent::__construct($board);
		$this->strategy = $strategy;	
	}
	
}

?>