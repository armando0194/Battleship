<?php

checkURLParameters();

function validateStrategy(){
	$strategy =  $_GET['strategy'];
	strtolower($strategy);
	if(!$strategy){
		$strategyErrorMessage = new ErrorResponse("Strategy not specified");
	}
	if($strategy != "smart" || $strategy != "random" || $strategy != "sweep") {
		$strategyErrorMessage = new ErrorResponse("Unknown Strategy");
	}
	else {
		return;
	}
	echo json_encode($strategyErrorMessage);
}

function validateDeployment(){
	$ships = $_GET['ships'];
	if(!$ships){
		return; // gen random deployment
	}
	$ships = explode(";",$ships);
	if(sizeof($ships) != 5){
		$deploymentErrorMessage = new ErrorResponse("Ship Deployment not well formed");
	}
	$ships = explode(",",$ships);
	foreach($ships as $ship){
		if(sizeof($ship) !=4){
			$deploymentErrorMessage = new ErrorResponse("Incomplete ship deployment");
		}
		list($name,$xPos,$yPos,$direction) = explode(",",$ship);
		if(validateShipName($name)){
			$deploymentErrorMessage = new ErrorResponse("Unknown ship name");
		}
		if(validateShipPosition($xPos) || validateShipPositio($YPos)){
			$deploymentErrorMessage = new ErrorResponse("Invalid Ship Position");
		}
		if(validateShipDirection($xPos,$yPos,$direction)){
			$deploymentErrorMessage = new ErrorResponse("Invalid Ship Direction");
		}
	}
}
function validateShipDirection($xPos,$yPos,$direction){
	if($xPos == 10 && $direction){
		return true;
	}
	if($yPos == 10 && direction){
		return true;
	}
	return false;
}
function validateShipPosition($pos){
	if($pos < 0 || $pos > 10){
		return true;
	}
	return false;
}
function validateShipName($name){
	strtolower($name);
	if(!$name || $name !="battleship" ||  $name !="aircraft+carrier" ||  $name !="submarine" || $name !="frigate" ||  $name !="minesweepere"){
		return true;
	}

	return false;
}

function checkURLParameters(){
	echo $strategy;

	validateStrategy();

}
?>