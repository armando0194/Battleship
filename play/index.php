<?php
	include "../common/Board.php";
	include "../common/Play.php";
	include "../common/Response.php";
	include "../common/GlobalFunctions.php";
	
	validateURLParameters();
	
 	function validateURLParameters(){
 
 		//if the URL parameters are not valid stop execution
 		if( !$pid = getPidValue() && !$shot = getShotValue()){
 			return;
 		}
 		
		echo $pid;
//  		echo $shot;
 		
 		
 	}
 	
 	function getPidValue(){
 		$pid =  $_GET["pid"];
 		
 		if( !$pid ){
 		//checks if pid is empty
 			$pidErrorResponse = Response::withReason( "Pid not specified" );
 		}
 		else if( !file_exists($pid . ".txt") ){
 		//checks if the pid exists
 			$pidErrorResponse = Response::withReason( "Unknown pid" );
 		}
 		
 		if( $pidErrorResponse ){
 		// if there was an error,  send an error respond
 			echo json_encode(array_filter((array) $pidErrorResponse, 'is_not_null'));
 			return null;
 		}
 		
 		return $pid;
 	}
 	
 	function getShotValue(){
 		$shot =  $_GET["shot"];
 		$coordinates = explode(",", $shot);
 		
 		if(!$shot){
 		//checks if the shot is empty
 			$shotErrorResponse = Response::withReason( "Shot not specified" ); 
 		} 
 		else if( sizeof($coordinates) != 2 ) {
 		//checks if there are two coordinates
 			$shotErrorResponse = Response::withReason( "Shot not well-formed" );
 		} else if( areCoordinatesValid($coordinates) ) {
 		//checks if the coordinates are between 1 and 10
 			$shotErrorResponse = Response::withReason( "Invalid shot position" );
 		}
 		
 		if( $shotErrorResponse ){
 			// if there was an error, return null and send a error response
 			echo json_encode(array_filter((array) $shotErrorResponse, 'is_not_null'));
 			return null;
 		}
 		
 		return new Play($coordinates[0], $coordinates[1]);
 	}
 	
 	function areCoordinatesValid( $coordinates ){
 		// traverse the coodinates and check that they are between 1 and 10
 		foreach ( $coordinates as $coordinate ){
 			// if the coordinates are not between 1 and 10 return false
 			if($coordinate > 0 || $coordinate <= 10){
 				return false;
 			}
 		}
 		return true;
 	}
?>



