<?php

namespace App\Facade;

use Illuminate\Http\Response as HttpResponse;
use App\Providers\MoveInterface;

class GameFacade implements MoveInterface
{

	function __construct(){
		$this->players =  config('app.players');
		$this->matrix =  config('app.matrix');
	}

    public function makeMove($boardState, $playerUnit = 'X') {
    	return $this->botTurn($boardState);
    }




    private function winingPatterns(){
    	return array(
    		[ [0,0],[1,0],[2,0] ], # 1st cols |
    		[ [0,1],[1,1],[2,1] ], # 2nd cols |
    		[ [0,2],[1,2],[2,2] ], # 3rd cols |

    		[ [0,0],[0,1],[0,2] ], # 1st row -
    		[ [1,0],[1,1],[1,2] ], # 2nd row -
    		[ [2,0],[2,1],[2,2] ], # 3rd row -

    		[ [0,0],[1,1],[2,2] ], # \
    		[ [2,0],[1,1],[0,2] ], # /
    	);
    }


    private function scanningTurns($boardState) {
    	
    	$winingPatterns = $this->winingPatterns();
    	$matrix = $this->matrix;

		// Checking all winning patterns, if any one won
    	foreach ($winingPatterns as $patterns) {

    		$player = [$this->players[0] => 0, $this->players[1] => 0];
    		foreach($patterns as $pattern) {
    			// Adding reserved blocks from total required to check is anyone win.
    			if ( $boardState[$pattern[0]][$pattern[1]] == $this->players[0] ) $player[$this->players[0]]++; // X
    			else if ( $boardState[$pattern[0]][$pattern[1]] == $this->players[1] ) $player[$this->players[1]]++; // O
    		}

    		// Checking if anyone win the current match
    		if ($player[$this->players[0]] == $matrix || $player[$this->players[1]] == $matrix) {
    			if ($player[$this->players[0]] > $player[$this->players[1]]) $playerWin = $this->players[0];
    			else $playerWin = $this->players[1];

    			return "Player $playerWin won!";
    			break;
    		}
    	}

    	// If dont win proceed
    	return "Please continue";
    }


    private function botTurnOptions(){
    	$matrix = $this->matrix;
    	for($row=0; $row<$matrix; $row++) {
    		for($col=0; $col<$matrix; $col++) {
    			$turns[] = [$row, $col];
    		}

    	}
    	return $turns;
    }


    private function botTurn($boardState){
		
		$winingPatterns = $this->winingPatterns();
		$matrix = $this->matrix;
		$availableTurnOptions = [];
		$tookPlace = false;

		// Checking all winning patterns, if any where bot can place to win
    	foreach ($winingPatterns as $patterns) {

    		$player = [$this->players[0] => 0, $this->players[1] => 0];
    		foreach($patterns as $pattern) {
    			if ( $boardState[$pattern[0]][$pattern[1]] == $this->players[0] ) $player[$this->players[0]]++;
    			else if ( $boardState[$pattern[0]][$pattern[1]] == $this->players[1] ) $player[$this->players[1]]++;
    			else if ( !in_array([$pattern[0],$pattern[1]], $availableTurnOptions) ) 
    				$availableTurnOptions[] = [$pattern[0],$pattern[1]];
    		}

    		// checking bot reserved block, if equals to 2 then should place last one to win
    		if ( $player[$this->players[1]] == $matrix-1 && $player[$this->players[0]] == 0 ) {

    			// getting last option to set to win, if already placed 2 
    			$lastOption = $availableTurnOptions[count($availableTurnOptions)-1];
    			$boardState[$lastOption[0]][$lastOption[1]] = 'A';
    			$tookPlace = true;
    			break;
    		}
    	}

    	// If did not placed any turn, getting available places to make a turn from bot
    	if ($tookPlace==false) {
    		$totalAvailablePlaces = count($availableTurnOptions)-1;
    		$place = rand(0, $totalAvailablePlaces);
    		$boardState[$availableTurnOptions[$place][0]][$availableTurnOptions[$place][1]] = 'C';
    		$tookPlace = true;
    	}

		// Check again after returning bot turn, either bot win or not.
    	//$this->scanningTurns($boardState);

    	return $boardState;
    }

}
