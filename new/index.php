<?php
include "../common/Response.php";
include "../common/Board.php";
include "../common/GlobalFunctions.php";

newGame();

/* new Game class 
 * response is a boolean: true - if success ; false - if error was found on new game
 * pid - unique id of the current game
 */
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
/*
 * Check for any errors on the url parameters
 * if no error is found return a json with the response and pid
 */
function newGame(){
	if(checkURLParameters()){
		$newGameResponse = new newGame(true);
		$newGameResponse ->toJson($this);
	}
}
/*
 * Read strategy url parameters and check for any errors on it
 * return a json with the error message if necessesary
 */
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
/*
 * Check for ship deployment on url parameters
 * return an error message in json form when necessary
 */
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
/*
 * Check for possible conflicts on ship direction
 * true-horizontal
 * false- vertical
 */
function validateShipDirection($xPos,$yPos,$direction){
	if($xPos == 10 && $direction){
		return true;
	}
	if($yPos == 10 && direction){
		return true;
	}
	return false;
}
/*
 * check for ship misplacement on board
 * x and y positions should be withing range of board size 1-10
 */
function validateShipPosition($pos){
	if($pos < 1 || $pos > 10){
		return true;
	}
	return false;
}
/*
 * Check all ship names and verify that the correct ships were placed.
 */
function validateShipName($name){
	strtolower($name);
	if(!$name || $name !="battleship" ||  $name !="aircraft+carrier" ||  $name !="submarine" || $name !="frigate" ||  $name !="minesweeper"){
		return true;
	}

	return false;
}
/*
 * Check url parameters
 */
function checkURLParameters(){
	$strategy = getStrategy();
	$deployment = getDeployment();

}
?>