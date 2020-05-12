<?php

class Morpiien
{
	private $board;
	private $player1;
	private $player2;
	
	public function __construct($player, $IA)
	{
		$this->player1 = $player;
		$this->player2 = $IA;
		
		$this->board = [
			'cell1' => 0, 'cell2' => 0, 'cell3' => 0, 
			'cell4' => 0, 'cell5' => 0, 'cell6' => 0,
			'cell7' => 0, 'cell8' => 0, 'cell9' => 0,
		];
	}
	
	private function play($move, $player)
	{
		if (isset($this->board[$move]) && $this->board[$move] === 0)
		{
			$this->board[$move] = $player;
			return true;
		}
		
		return false;
	}
	
	// Vérifie le move et le joue
	public function player1Play($move)
	{
		return $this->play($move, $this->player1);
	}
	
	// Vérifie le move et le joue
	public function player2Play($move)
	{
		return $this->play($move, $this->player2);
	}
	
	// Comportement de l'IA
	public function AIPlay()
	{
		// Copie
		$board = $this->board;
		$emptyCells = Morpiien::emptyCells($this->board);
		
		foreach ($emptyCells as $cell)
		{
			$board[$cell] = $this->player2;
			if (Morpiien::isWon($board) === $this->player2)
			{
				$this->board[$cell] = $this->player2;
				return $cell;
			}
			$board[$cell] = 0;
		}
		
		foreach ($emptyCells as $cell)
		{
			$board[$cell] = $this->player1;
			if (Morpiien::isWon($board) === $this->player1)
			{
				$this->board[$cell] = $this->player2;
				return $cell;
			}
			$board[$cell] = 0;
		}
		
		$choice = $emptyCells[rand(1, sizeof($emptyCells)) - 1];
		$this->board[$choice] = $this->player2;
		
		return $choice;
	}
	
	// Retourne qui a gagné si quelqu'un a gagné
	public function isFinished()
	{
		return Morpiien::isWon($this->board);
	}
	
	private static function isWon($board)
	{
		if (($align = Morpiien::hAlignment($board)) !== false)
			return $align;
		else if (($align = Morpiien::vAlignment($board)) !== false)
			return $align;
		else if (($align = Morpiien::diagAlignment($board)) !== false)
			return $align;
		else if (sizeof(Morpiien::emptyCells($board)) === 0)
			return 'No one';
		
		return false;
	}
	
	// Liste les cellules vides dans le plateau
	private static function emptyCells($board)
	{
		$cells = [];
		foreach ($board as $cell => $value)
			if ($value === 0) $cells[] = $cell;
		
		return $cells;
	}
	
	// Regarde s'il y a un alignement horizontal
	private static function hAlignment($board)
	{
		if ($board['cell1'] !== 0 &&
			$board['cell1'] === $board['cell2'] &&
			$board['cell1'] === $board['cell3'])
			return $board['cell1'];
		if ($board['cell4'] !== 0 &&
			$board['cell4'] === $board['cell5'] &&
			$board['cell4'] === $board['cell6'])
			return $board['cell4'];
		if ($board['cell7'] !== 0 &&
			$board['cell7'] === $board['cell8'] &&
			$board['cell7'] === $board['cell9'])
			return $board['cell7'];
		
		return false;
	}
	
	// Regarde s'il y a un alignement vertical
	private static function vAlignment($board)
	{
		if ($board['cell1'] !== 0 &&
			$board['cell1'] === $board['cell4'] &&
			$board['cell1'] === $board['cell7'])
			return $board['cell1'];
		if ($board['cell2'] !== 0 &&
			$board['cell2'] === $board['cell5'] &&
			$board['cell2'] === $board['cell8'])
			return $board['cell2'];
		if ($board['cell3'] !== 0 &&
			$board['cell3'] === $board['cell6'] &&
			$board['cell3'] === $board['cell9'])
			return $board['cell3'];
		
		return false;
	}
	
	// Regarde s'il y a un alignement diagonal
	private static function diagAlignment($board)
	{
		if (($board['cell1'] !== 0 &&
			 $board['cell1'] === $board['cell5'] &&
			 $board['cell1'] === $board['cell9']) ||
			($board['cell3'] !== 0 &&
			 $board['cell3'] === $board['cell5'] &&
			 $board['cell3'] === $board['cell7']))
			return $board['cell5'];
		
		return false;
	}
}
?>
