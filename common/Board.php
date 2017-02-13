<?php
class Board{
	public $board;
	public $columns = 10;
	public $rows = 10;
	public $empty = 0;
	public $aircraft = 1;
	public $battleship = 2;
	public $frigate = 3;
	public $submarine = 4;
	public $minesweeper = 5;
	
	function __construct(){
		$this->initBoard();
	}
	/*
	 * Creates empty board
	 */
	function initBoard(){
		$this->board = Array();
		for ( $currCol = 0; $currCol < $this->columns; $currCol++){
			array_push($this->board, Array());
			for ( $currRow = 0; $currRow < $this->rows; $currRow++){
				array_push($this->board[$currCol], $this->empty);
			}
		}
		print_r($this->board);
	}
}

$hola = new Board();

/*
 0 0 0 0 0 0 0 0 0 0
 0 0 0 1 1 1 0 0 0 0
 0 0 0 0 0 0 0 0 0 0
 0 0 0 0 0 2 0 0 0 0
 0 0 0 0 0 2 0 0 0 0
 0 0 0 0 0 0 0 0 0 0
 0 0 0 0 0 0 0 0 0 0
 0 0 0 0 0 0 0 0 0 0
 */
?>



