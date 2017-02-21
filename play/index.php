<?php
include "../common/Board.php";
include "Game.php";
include "../common/Ship.php";
include "../common/Shot.php";
include "../common/Response.php";

// validate pid URL parameter
//$pid = getPidValue();
$pid = "58abcbcd3ee2d";
//if the pid is empty, stop excecution
if ( empty($pid) ){
	return;
}

//Read game state from file and map it to a game class
$json = file_get_contents("games/" . $pid . ".txt");
$game = Game::mapJsonToClass($json);
print_r( $game );
// $clienShot = attemptClientShot($game);

// if ( empty($clienShot) ){
// 	return;
// }



function getPidValue() {
	$pid = $_GET ["pid"];
	
	if ( !$pid ) {
		// checks if pid is empty
		$pidErrorResponse = Response::withReason ( "Pid not specified" );
	} else if ( !file_exists($pid . ".txt") ){
		// checks if the pid exists
		$pidErrorResponse = Response::withReason ( "Unknown pid" );
	} else {
		// if there was not an error, send pid back
		return $pid;
	}
	
	// if there was an error, send an error respond
	echo $pidErrorResponse->toJson();
}

/**
 * 
 * @return Play
 */
function attemptClientShot($game) {
	$shot = $_GET ["shot"];
	$coordinates = explode ( ",", $shot );
	
	if (! $shot) {
	// checks if the shot is empty
		$shotErrorResponse = Response::withReason ("Shot not specified");
	} else if (sizeof ( $coordinates ) != 2) {
	// checks if there are two coordinates
		$shotErrorResponse = Response::withReason("Shot not well-formed");
	} else if ( !areCoordinatesValid($coordinates) || $game->getComputerPlayer()->getBoard()->fireAt(new Shot($coordinates[0], $coordinates[1])) ) {
	// checks if the coordinates are between 1 and 10
		$shotErrorResponse = Response::withReason("Invalid shot position");
	} else {
		return new Shot( $coordinates[0], $coordinates[1] );
	}
	
	echo $shotErrorResponse->toJson();
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
?>



