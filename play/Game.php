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
		$data = json_decode($json);
		//print_r($data);
		$instance = new self(null, null, null);
		$numeberOfShips = 5;
		
		$clientShips = $instance->getShips( $data->players[0]->board->ships );
		$serverShips = $instance->getShips( $data->players[1]->board->ships );

		$clientBoard = new Board((Array) $data->players[0]->board->board, $clientShips);
		$serverBoard = new Board((Array) $data->players[1]->board->board, $serverShips);
		
		$clientPlayer = new Player($clientBoard);
		$compPlayer = new ComputerPlayer("", $serverBoard);
		
		$instance->players = Array($clientPlayer, $compPlayer);
		$instance->difficulty = $data->strategy;
		$instance->pid = $data->pid;
		return $instance;
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
	
	function getShips($ships){
		foreach ($ships as $shipNumber => $ship) {
			$shipDeployment[$shipNumber] = new Ship($ship->name, $ship->size, $ship->xPos, $ship->yPos, $ship->direction);
		}
		return $shipDeployment;
	}
	function jsonToFile(){
		file_put_contents( "../play/games/" . $this->pid . ".txt", $this->toJson() );
	}
}
?>