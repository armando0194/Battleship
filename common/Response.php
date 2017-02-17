<?php
/**
 * 
 * @author Manuel Hernandez
 *
 */

class Response implements \JsonSerializable{
	private $response;
	private $reason;
	private $pid;
	private $ack_shot;
	private $shot;
	
	/**
	 * constructor
	 */
	public function __construct( $response )
	{
		$this->response = $response;
	}
	
	public static function withReason( $reason )
	{
		$instance = new self( false );
		$instance->reason = $reason;
		return $instance;
	}
	
	public static function withPid() 
	{
		$instance = new self( true );
		$instance->pid = uniqid();
		return $instance;
	}
	
	public static function withShots($shot, $ack_shot) 
	{
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
	
	/**
	 * Clones the current object, and converts it to
	 * Json but it ommits null values.
	 * @return json in a string
	 */
	public function toJson()
	{
		$obj = clone $this;
		$keys = get_object_vars($obj);
		foreach ($keys as $key => $value) {
			if ( is_null($value) ) {
				unset($obj->{$key});
			}
		}
		return json_encode($obj);
	}
}

?>