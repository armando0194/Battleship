<?php
//define info properties
define("BOARD_SIZE", 10);
$ships = Array(new ShipInfo("Aircraft carrier", 5), new ShipInfo("Battleship", 4), new ShipInfo("Frigate", 3), new ShipInfo("Submarine", 3), new ShipInfo("Minesweeper", 2));
$strategies = Array("Smart", "Random", "Sweep");

//Create object and return it as a json
$info = new Info(BOARD_SIZE, $strategies, $ships);
echo $info->toJson();

/**
 * Class that defines the structure of the 
 * json responses
 */
class Info {
	public $size;       //board size
	public $strategies; //array of strategies
	public $ships;  //array of ships

	/**
	 * Info constructor
	 * @param int $size - board size
	 * @param array $strategies - array of strategies
	 * @param array $ship - array of ships
	 */
	function __construct($size, $strategies, $ships)
	{
		$this->size = $size;
		$this->strategies = $strategies;
		$this->ships = $ships;
	}
	
	/**
	 * Converts the object to json
	 * @return string - json 
	 */
	function toJson(){
		return json_encode( $this );
	}
}

/**
 * Class representation of a ship 
 * that contains its name and size
 */
class ShipInfo{
	public $name;  // ship's name
	public $size;  // ship's size

	/**
	 * Constructor
	 * @param string $name - name of the ship 
	 * @param int $size    - ship size
	 */
	function __construct($name, $size)
	{
		$this->name = $name;
		$this->size = $size;	
	}
}
?>


