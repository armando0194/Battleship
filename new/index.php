<?php

checkURLParameters();

function validateStrategy(){
	$strategy =  $_GET['strategy'];
	if(true){
		$startegyErrorMessage = new ErrorResponse("Strategy not specified");
	}
	if($strategy == "Smart" || $strategy == "Random") {
		
	}
	else {
		return;
	}
	echo json_encode($startegyErrorMessage);
}

function checkURLParameters(){
	echo $strategy;
	
	validateStrategy();
		
}

?>