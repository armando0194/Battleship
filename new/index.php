<?php
include "../common/Response.php";
include "../common/Board.php";
include "../common/GlobalFunctions.php";

newGame();
class newGame {
	public $response;
	public $pid;
	

	function __construct($response){
		$this->response = $response;
		$this->pid = uniqid();
	}
	function toJson($this){
		json_encode(array_filter((array) $this, 'is_not_null'));
	}
}
function newGame(){
	if(checkURLParameters())
	$newGameResponse = new newGame(true);
	$newGameResponse ->toJson($this);
}

function getStrategy(){
	$strategy =  $_GET['strategy'];
	strtolower($strategy);
	if(!$strategy){
		$strategyErrorMessage = Response::withReason("Strategy not specified");
	}
	if($strategy != "smart" || $strategy != "random" || $strategy != "sweep") {
		$strategyErrorMessage = Response::withReason("Unknown Strategy");
	}
	else {
		return $strategy;
	}
	echo json_encode(array_filter((array) $strategyErrorResponse, 'is_not_null'));
}

function getDeployment(){
	$ships = $_GET['ships'];
	if(!$ships){
		return; // gen random deployment
	}
	$ships = explode(";",$ships);
	if(sizeof($ships) != 5){
		$deploymentErrorMessage = Response::withReason("Ship Deployment not well formed");
	}
	$ships = explode(",",$ships);
	foreach($ships as $ship){
		if(sizeof($ship) !=4){
			$deploymentErrorMessage = Response::withReason("Incomplete ship deployment");
		}
		list($name,$xPos,$yPos,$direction) = explode(",",$ship);
		if(validateShipName($name)){
			$deploymentErrorMessage = Response::withReason("Unknown ship name");
		}
		if(validateShipPosition($xPos) || validateShipPositio($YPos)){
			$deploymentErrorMessage = Response::withReason("Invalid Ship Position");
		}
		if(validateShipDirection($xPos,$yPos,$direction)){
			$deploymentErrorMessage = Response::withReason("Invalid Ship Direction");
		}
	}
	
}
function validateShipDirection($xPos,$yPos,$direction){
	if($xPos == 10 && $direction){
		return true;
	}
	if($yPos == 10 && direction){
		return true;
	}
	return false;
}
function validateShipPosition($pos){
	if($pos < 1 || $pos > 10){
		return true;
	}
	return false;
}
function validateShipName($name){
	strtolower($name);
	if(!$name || $name !="battleship" ||  $name !="aircraft+carrier" ||  $name !="submarine" || $name !="frigate" ||  $name !="minesweeper"){
		return true;
	}

	return false;
}

function checkURLParameters(){
	$strategy = getStrategy();
	$deployment = getDeployment();

}
?>