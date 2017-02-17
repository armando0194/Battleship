<?php

//define info properties
define("BOARD_SIZE", 10);
$ships = Array(new Ship("Aircraft carrier", 5), new Ship("Battleship", 4), new Ship("Frigate", 3), new Ship("Submarine", 3), new Ship("Minesweeper", 2));
$strategies = Array("Smart", "Random", "Sweep");

//create object and return it as a json
$info = new Info(BOARD_SIZE, $strategies, $ships);
echo $info->toJson();

	

class Info {
	public $size;
	public $strategies;
	public $ships;

	function __construct($Size, $Strategies, $Ships)
	{
		$this->size = $Size;
		$this->strategies = $Strategies;
		$this->ships = $Ships;
	}
	
	function toJson(){
		return json_encode( $this );
	}
}

class Ship{
	public $name;
	public $size;

	function __construct($Name, $Size)
	{
		$this->size = $Size;
		$this->name = $Name;
	}
}

?>


