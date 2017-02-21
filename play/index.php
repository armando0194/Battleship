<?php
include "../common/Board.php";
include "Game.php";
include "Ship.php";
include "../common/Shot.php";
include "../common/Response.php";
include "../common/GlobalFunctions.php";

// $pid = getPidValue();
// $pid = "test";
// if ( empty($pid) ){
// 	return;
// }

// $json = file_get_contents("test.txt");
// $game = Game::mapJsonToClass($json);
// attemptClientShot($game);

$board = new Board(null, null);
//$board->printBoard();
$shot =  new Shot(1, 1);

$board->fireAt($shot);
$board->printBoard();

// $ships = array(  new Ship("Aircraft+carrier",1,6,false), new Ship("Battleship",7,5,true), new Ship("Frigate",2,1,false), new Ship("Submarine",9,6,false), new Ship("Minesweeper",10,9,false) );
// $ships2 = array(  new Ship("Aircraft+carrier",1,6,false), new Ship("Battleship",7,5,true), new Ship("Frigate",2,1,false), new Ship("Submarine",9,6,false), new Ship("Minesweeper",10,9,false) );

// $board = new Board(null);
// $board2 = new Board(null);

// $player = new Player($board, $ships);
// $compPlayer = new ComputerPlayer("Smart", $board2, $ships2);

// $players = Array($player, $compPlayer);

// $game = new Game($players, "Smart");
// file_put_contents( "test.txt", json_encode($game) );




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



