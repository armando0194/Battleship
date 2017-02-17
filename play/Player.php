<?php
class Player{
	public $board;
	public $ships;
	
	function __construct($board, $ships){
		$this->board = $board;
		$this->ships = $ships;
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
	
	function __construct($strategy, $board, $ships){
		parent::__construct($board, $ships);
		$this->strategy = $strategy;	
	}
	
}

?>