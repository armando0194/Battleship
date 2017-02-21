<?php
include "../common/Ship.php";

//define info properties
define("BOARD_SIZE", 10);
$ShipInfos = Array(new ShipInfo("Aircraft carrier", 5), new ShipInfo("Battleship", 4), new ShipInfo("Frigate", 3), new ShipInfo("Submarine", 3), new ShipInfo("Minesweeper", 2));
$strategies = Array("Smart", "Random", "Sweep");

//create object and return it as a json
$info = new Info(BOARD_SIZE, $strategies, $ShipInfos);
echo $info->toJson();

class Info {
	public $size;
	public $strategies;
	public $ShipInfos;

	function __construct($size, $strategies, $ship)
	{
		$this->size = $size;
		$this->strategies = $strategies;
		$this->ShipInfos = $ship;
	}
	
	function toJson(){
		return json_encode( $this );
	}
}


class ShipInfo{
	public $name;
	public $size;

	function __construct($Name, $Size)
	{
		$this->size = $Size;
		$this->name = $Name;
	}
}
?>


