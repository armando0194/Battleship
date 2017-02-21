<?php 
include "Player.php";
include "Random.php";
	
class Game {
	public $players;
	public $difficulty;
	public $pid;
	
	function __construct($players, $difficulty, $pid){
		$this->players = $players;
		$this->difficulty = $difficulty;
		$this->pid = $pid;
	}

	function getComputerPlayer(){
		return $this->players[1];
	}
	
	function getClientPlayer(){
		return $this->players[0];
	}
	
	static function mapJsonToClass($json){
		/*$data = json_decode($json);
		$instance = new self(null, null, null);
		$clientShips = array();
		$serverShips = array();
		$numeberOfShips = 5;
		
		for($currShip = 0; $currShip < $numeberOfShips; $currShip++){
			$currClientShip = $data->players[0]->ships[$currShip];
			$currServerShip = $data->players[1]->ships[$currShip];
			array_push( $clientShips, new Ship($currClientShip->name, $currClientShip->xPos, $currClientShip->yPos, $currClientShip->direction) );
			array_push( $serverShips, new Ship($currServerShip->name, $currServerShip->xPos, $currServerShip->yPos, $currServerShip->direction) );
		}

		$clientBoard = new Board((Array) $data->players[0]->board->board);
		$serverBoard = new Board((Array) $data->players[1]->board->board);
		
		$player = new Player($clientBoard, $clientShips);
		$compPlayer = new ComputerPlayer("", $serverBoard, $serverShips);
		
		$instance->players = Array($player, $compPlayer);
		$instance->difficulty = $data->difficulty;
		return $instance;*/
	}
	
	/**
	 * Clones the current object, and converts it to
	 * Json but it ommits null values.
	 * @return json in a string
	 */
	function toJson()
	{
		return json_encode($this);
	}
	
	function jsonToFile(){
		file_put_contents( "../play/games/" . $this->pid . ".txt", $this->toJson() );
	}
}
?>