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

class Response{
	public $response;
		
	 /**
     * constructor
     */
   	public function __construct($response) 
	{
		$this->response = $response;
	}

    /**
     * Response setter
     */
    public function setResponse( $response) {
        $this->response = $response;
    }
}

class ErrorResponse extends Response{
	public $reason;	

	public function __construct($reason) 
	{
		parent::__construct(false);
		$this->reason = $reason;
	}

    /**
     * Reason setter
     */
    public function setReason( $reason) 
    {
        $this->reason = $reason;
    }
}

class SuccessResponse extends Response{
	public $pid;	

	public function __construct($pid) 
	{
		parent::__construct(true);
		$this->pid = $pid;
	}

    /**
     * Reason setter
     */
    public function setPid( $pid) 
    {
        $this->pid = $pid;
    }
}
?>