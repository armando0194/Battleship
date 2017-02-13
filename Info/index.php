<?php
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
	
	function returnInfoJson() {
		//Create new ships
		$aircraft = new Ship("Aircraft carrier", 5);
		$battleship = new Ship("Battleship", 4);
		$frigate = new Ship("Frigate", 3);
		$submarine = new Ship("Submarine", 3);
		$minesweeper = new Ship("Minesweeper", 2);
		
		//create json and return it
		$InfoObject = new Info(10, Array("Smart", "Random", "Sweep"), Array($aircraft, $battleship, $frigate, $submarine, $minesweeper));
		header('Content-Type: application/json');
		echo json_encode($InfoObject);
	}
	
	returnInfoJson();
?>


