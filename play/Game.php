<?php 
include "Player.php";
include "Random.php";
include "../new/Smart.php";
	
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
		$instance = new self(null, null, null);
		$numeberOfShips = 5;
		
		$clientShips = $instance->getShips( $data->players[0]->board->ships );
		$serverShips = $instance->getShips( $data->players[1]->board->ships );
		
		$clientBoardArr = array();
		$serverBoardArr = array();
		$instance->objToArray($data->players[0]->board->board,$clientBoardArr);
		$instance->objToArray($data->players[1]->board->board,$serverBoardArr);
		$clientBoard = new Board( $clientBoardArr, $clientShips );
 		$serverBoard = new Board( $serverBoardArr, $serverShips );
		
		$clientPlayer = new Player($clientBoard);
		$compPlayer = new ComputerPlayer("", $serverBoard);
		
		$instance->players = Array($clientPlayer, $compPlayer);
		$instance->difficulty = $data->strategy;
		$instance->pid = $data->pid;
		return $instance;
	}
	
	function objToArray($obj, &$arr){
	
		if(!is_object($obj) && !is_array($obj)){
			$arr = $obj;
			return $arr;
		}
	
		foreach ($obj as $key => $value)
		{
			if (!empty($value))
			{
				$arr[$key] = array();
				$this->objToArray($value, $arr[$key]);
			}
			else
			{
				$arr[$key] = $value;
			}
		}
		return $arr;
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
	
	function generateComputeMove(){
		
		$shot = $this->getComputerPlayer()->generateComputerMove( $this->getClientPlayer()->getBoard() );
		print_r( $this->getClientPlayer()->getBoard()->printBoard() );
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