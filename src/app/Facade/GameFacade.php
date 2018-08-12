<?php

namespace App\Facade;

use Illuminate\Http\Response as HttpResponse;
use App\Providers\MoveInterface;

class GameFacade implements MoveInterface
{

    public function makeMove($boardState, $playerUnit = 'X') {
    	return $this->scanningTurns($boardState);
    }


    public function winingPatterns(){
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


    public function scanningTurns($boardState, $matrix=3) {
    	
    	$winingPatterns = $this->winingPatterns();

    	foreach ($winingPatterns as $patterns) {
    		$player = ['X' => 0, 'O' => 0];
    		foreach($patterns as $pattern) {
    			if ( $boardState[$pattern[0]][$pattern[1]] == 'X' ) $player['X']++;
    			else if ( $boardState[$pattern[0]][$pattern[1]] == 'O' ) $player['O']++;
    		}

    		if ($player['X']==$matrix || $player['O']==$matrix) {
    			if ($player['X'] > $player['O']) $playerWin = "X";
    			else $playerWin = "O";

    			return "Player $playerWin won!";
    			break;
    		}
    	}
    		return "Please continue";
    }


    public function botTurnOptions($matrix=3){
    	for($row=0; $row<$matrix; $row++) {
    		for($col=0; $col<$matrix; $col++) {
    			$turns[] = [$row, $col];
    		}

    	}
    	return $turns;
    }


    public function botTurn(){

    }

}
