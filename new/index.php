<?php
include "../common/Response.php";
include "../common/Board.php";
include "../play/Game.php";
include "../common/Ship.php";

$shipsInfo = Array("Aircraft+carrier" => 5, "Battleship" => 4, "Frigate" => 3, "Submarine"=> 3, "Minesweeper" => 2);
$strategy = getStrategy();

//stop if startegy null
if( empty($strategy) ){
	return;
}

//generate human player board and ship deployment
$ships = $_GET['ships'];

if($ships) {
// if ships is null, generate random deployment
	$clientBoard = Board::withRandomDeployment();
} else {
// otherwise, validate deployment
	$clientBoard = Board::withEmptyBoard();
	$clientShips = getDeployment($clientBoard);
	if( empty($clientShips) ){
		return;
	}
	else{
		$clientBoard->setShips();
	}
}

$players = array( new Player($clientBoard), new ComputerPlayer($strategy, Board::withRandomDeployment()) );
$response = Response::withPid();
$game = new Game($players, $strategy, $response->getPid());
$game -> jsonToFile();
print_r($game);
echo $response->toJson();


//////////////////////URL Parameter validation//////////////////////////
/*
 * Read strategy url parameters and check for any errors on it
 * return a json with the error message if necessesary
 */
function getStrategy(){
	$strategy =  $_GET['strategy'];
	if(!$strategy){
		$strategyErrorMessage = Response::withReason("Strategy not specified");
	}
	// fix comparison
	else if( !isStartegyNameValid($strategy) ) {
		$strategyErrorMessage = Response::withReason("Unknown Strategy");
	}
	else {
		//$start = new $strategy();
		return $strategy;
	}
	echo $strategyErrorMessage->toJson();
}

function isStartegyNameValid($name){
	$strategies = array("Smart", "Random", "Sweep");
	
	foreach($strategies as $strategy){
		if($strategy == $name){
			return true;
		}
	}
	return false;
	
}
/*
 * Check for ship deployment on url parameters
 * return an error message in json form when necessary
 */
function getDeployment( $clientBoard ){
	$ships = $_GET['ships'];
	$ships = explode(";",$ships);    // get ships
	
	// check if there are 5 chips, throw error if it is not well formed
	if(sizeof($ships) != 5){
		$deploymentErrorMessage = Response::withReason("Ship Deployment not well formed");
		$deploymentErrorMessage->toJson();
		return null;
	}
	
	//traverse all the ships and validate their position, and deployment information
	$shipNumRep = 2;
	foreach($ships as $ship){
		$currShip = list($name,$xPos,$yPos,$direction) = explode(",",$ship);
		$size = $this->getShipSize($name);
		if(sizeof($currShip) != 4){
			$deploymentErrorMessage = Response::withReason("Incomplete ship deployment");
		}
		else if( validateShipName($name) ){
			$deploymentErrorMessage = Response::withReason("Unknown ship name");
		}
		else if( placeShip($xPos, $yPos, $direction, ($direction? $xPos: $yPos) + ($size-1), $ship) ){
			$deploymentErrorMessage = Response::withReason("Invalid Ship Position");
		}
		else if( validateShipDirection($xPos, $yPos, $direction, $size) ){
			$deploymentErrorMessage = Response::withReason("Invalid Ship Direction");
		}
		else {
			$shipDeployment[$shipNumRep] = new Ship($name, $size, $xPos, $yPos, $direction);
			$shipNumRep++;
		}	
		
		if( !empty($deploymentErrorMessage) ){
			$deploymentErrorMessage->toJson();
			return null;
		}
	}
	return $shipDeployment;
}


/*
 * Check for possible conflicts on ship direction
 * true-horizontal
 * false- vertical
 */
function validateShipDirection($xPos, $yPos, $direction, $size){
	if($xPos + ($size - 1) == 10 && $direction){
		return true;
	}
	if($yPos + ($size - 1) == 10 && !direction){
		return true;
	}
	return false;
}

function areCoordinatesValid($coordinates) {
	// traverse the coodinates and check that they are between 1 and 10
	foreach ( $coordinates as $coordinate ) {
		// if the coordinates are not between 1 and 10 return false
		if ( !is_numeric($coordinate) || $coordinate < 1 || $coordinate > 10 ){
			return false;
		}
	}
	return true;
}

function getShipSize(){
	return $this->shipsInfo[$name];
}

/*
 * Check all ship names and verify that the correct ships were placed.
 */
function validateShipName($name){
	$ship = $this->shipsInfo[$name];
	
	if( empty($ship) ){
		return false;
	}

	return true;
}


?>