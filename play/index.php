<?php
	include "../common/Board.php";
	include "../common/Play.php";
	include "../common/Response.php";
	
	validateURLParameters();
	
 	function validateURLParameters(){
 		
 		$pid =  $_GET["pid"];
 		
 		if(!$pid){
 			echo "Pid not specified";
 		}
 		else if( !file_exists($pid . ".txt") ){
 			echo "Unknown pid";
 		}
 		
 		$shot =  $_GET["shot"];
 		if(!$pid){
 			echo "Shot not specified";
 		}
 		
 		$coordinates = explode(",", $shot);
 		if( sizeof($coordinates) != 2){
 			"Shot not well-formed";
 		}
 		
 		foreach ($coordinates as $coordinate){
 			if($coordinate > 10 || $coordinate < 10){
 				echo "Invalid shot position";
 			}
 		}	
 	}
 	
	//$test = new Board();
// // 	$json_data = json_encode($test);
// // 	file_put_contents('test.txt', $json_data);

// 	$json_data = file_get_contents('test.txt');
// 	$json = (Array)json_decode($json_data, true);
	$shot = new Play(0, 2);
// 	$test = new Board();
// 	$test->__constructByJSON($json);
// 	print_r($test);
// 	$test->fireAt($shot);
// 	print_r($test);
// 	print_r(json_encode($shot));
	
// 	$shot = new Play(0, 3);
// 	$test->fireAt($shot);
// 	print_r($test);
// 	print_r(json_encode($shot));
	$test = new Response(true);
	
	function is_not_null($var)
	{
		return !is_null($var);
	}
	
	echo json_encode(array_filter((array) $test, 'is_not_null'));
	
	/**
	 *   0 0 0 0 0 0 0 0 0 0 
	 *   0 0 0 0 0 2 0 0 0 0  
	 *   0 0 0 0 0 2 0 0 0 0  
	 *   0 0 0 0 3 3 3 3 0 0  
	 *   0 0 0 0 0 0 0 0 0 0  
	 *   0 0 0 0 0 0 0 0 0 0  
	 *   0 0 0 0 0 0 0 0 0 0 
	 *   0 0 0 0 0 0 0 0 0 0  
	 *   0 0 0 0 0 0 0 0 0 0  
	 *   0 0 0 0 0 0 0 0 0 0   
	 */
?>



