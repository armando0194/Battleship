<?php

define("NUMBER_OF_SHIPS", 5);
define("PATH", "../writable/");
define("BOARD_SIZE", 10);
define("MIN_COORDINATE", 1);
define("MAX_COORDINATE", 10);
//Board dimension
define("ROWS", 10);
define("COLUMNS", 10);

//Empty and hit cell numerical representation
define("EMPTYCELL", 0);
define("HIT", 1);

//Numerical representation of the ships in the board
define("AIRCRAFT", 2);
define("BATTLESHIP", 3);
define("FRIGATE", 4);
define("SUBMARINE", 5);
define("MINESWEEPER", 6);

/**
 * Checks if the coordinates are whitin the
 * board range
 * @param unknown $coordinates
 * @return boolean
 */
function areCoordinatesValid($coordinates) {
	// traverse the coodinates and check that they are between 1 and 10
	foreach ( $coordinates as $coordinate ) {
		// if the coordinates are not between 1 and 10 return false
		if (!is_numeric($coordinate) || $coordinate < MIN_COORDINATE || $coordinate > MAX_COORDINATE){
			return false;
		}
	}
	return true;
}
?>