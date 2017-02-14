<?php
/**
 * 
 * @author Manuel Hernandez
 *
 */

class Response implements \JsonSerializable{
	public $response;
	public $reason;
	public $pid;
	public $ack_shot;
	public $shot;
	
	/**
	 * constructor
	 */
	public function __construct( $response )
	{
		$this->response = $response;
	}
	
	public static function withReason( $reason ) {
		$instance = new self( false );
		$instance->reason = $reason;
		return $instance;
	}
	
	public static function withPid() {
		$instance = new self( true );
		$instance->pid = uniqid();
		return $instance;
	}
	
	public static function withShots($shot, $ack_shot) {
		$instance = new self( true );
		$instance->shot = $shot;
		$instance->ack_shot = $ack_shot;
		return $instance;
	}
	
	public function jsonSerialize()
	{
		$vars = get_object_vars($this);
	
		return $vars;
	}
}

?>