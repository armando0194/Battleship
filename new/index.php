<?php
include "../common/Response.php";
include "../common/Board.php";
include "../common/GlobalFunctions.php";
include "../play/Game.php";
include "../play/Ship.php";
include "../play/Player.php";


newGame();

////////////////////////////////New Game creation//////////////////////

 



/*
 * s
 * Generate the board and ship deployment for AI and human player
 * generate new game
 * save game into a text file
 */
function newGame(){
	$strategy = getStrategy();
	//generate human player board and ship deployment
	$urlShips = $_GET['ships'];
	if(!$urLships){
		$playerShips = randomDeployment();
	}else{
		$playerShips = getDeployment();
	}
	$playerBoard = new Board($playerShips);
	$humanPlayer = new Player($playerBoard,$playerShips);
	
	//generate AI Player board and ship deployment
	$AIShips = randomDeployment();
	$AIBoard = new Board($AIShips);
	$AIPlayer = new ComputerPlayer($strategy,$AIBoard,$AIShips);
	//generate players and game
	$players = Array($humanPlayer,$AIPlayer);
	$response = Response::withPid();
	
	$game = new Game($players,$strategy,$response->getPid());
	$game -> jsonToFile();
	echo $response;
}


//////////////////////URL Parameter validation//////////////////////////
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
	$ships = explode(";",$ships);
	if(sizeof($ships) != 5){
		$deploymentErrorMessage = Response::withReason("Ship Deployment not well formed");
	}
	$deployment = Array();
	$ships = explode(",",$ships);
	foreach($ships as $ship){
		if(sizeof($ship) !=4){
			$deploymentErrorMessage = Response::withReason("Incomplete ship deployment");
		}
		$currShip= list($name,$xPos,$yPos,$direction) = explode(",",$ship);
		
		if(validateShipName($name)){
			$deploymentErrorMessage = Response::withReason("Unknown ship name");
		}
		if(validateShipPosition($xPos) || validateShipPositio($YPos)){
			$deploymentErrorMessage = Response::withReason("Invalid Ship Position");
		}
		if(validateShipDirection($xPos,$yPos,$direction)){
			$deploymentErrorMessage = Response::withReason("Invalid Ship Direction");
		}
		$currShip = new Ship($name,$xPos,$yPos,$direction);
		array_push($deployment,$currShip);
		
	}
	return $deployment;
	
	
	
	
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


?>