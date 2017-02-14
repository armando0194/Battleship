<?php
	include "../common/Board.php";
	include "../common/Play.php";
	
	validateURLParameters();
	
 	function validateURLParameters(){
 		$pid =  $_GET["pid"];
 		if(!$pid){
 			echo "failed";
 		}
 		//{"response": false, "reason": "Pid not specified"}
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



