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
    	
    	// Scanning if already someone win
    	$response = $this->scanningTurns($boardState);
    	if (isset($response[3])) return response()->json($response, HttpResponse::HTTP_CREATED);

    	// If no one win yet, then proceed with robot turn
    	$botResponse = $this->botTurn($boardState);
    	 if (isset($botResponse[3])) return response()->json($botResponse, HttpResponse::HTTP_CREATED);


    	return response()->json($botResponse, HttpResponse::HTTP_OK);
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

		// Checking all winning patterns, if any one already won
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

    			// return success with status code 201, as player won this match
    			return $botCoordinates = $this->generateCoordinatesResponse(NULL, NULL, $playerWin, "Player $playerWin Won!!");
    			//return response()->json($botCoordinates, HttpResponse::HTTP_CREATED);
    			break;
    		}
    	}    		 
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

                //counting how much occupied by each user to get wining or defense coordinates
    			if ( $boardState[$pattern[0]][$pattern[1]] == $this->players[0] ) $player[$this->players[0]]++;
    			else if ( $boardState[$pattern[0]][$pattern[1]] == $this->players[1] ) $player[$this->players[1]]++;
    			else if ( !in_array([$pattern[0],$pattern[1]], $availableTurnOptions) ) 
    				                                    $availableTurnOptions[] = [$pattern[0],$pattern[1]];

    			// to set empty place to get win accurately
    			if ($boardState[$pattern[0]][$pattern[1]] == "") $lastEmpty = [$pattern[0],$pattern[1]];
    		}

    		// checking bot moves, if got max then should place last one to win            
    		if ( $player[$this->players[1]] == $matrix-1 && $player[$this->players[0]] == 0)  {
    			// getting last empty option to set to win, if already placed others 
    			$botCoordinates = $this->generateCoordinatesResponse($lastEmpty[0],  $lastEmpty[1], 
    																 $this->players[1], "Player ".$this->players[1]." Won!");
    			$tookPlace = true;
    			break;
    		} else if ($player[$this->players[0]] == $matrix-1 && $player[$this->players[1]] == 0) {
                // if found any place where oponent can place to win, hold that position to move if bot is not wining
                $defenseCoordinates = [$lastEmpty[0], $lastEmpty[1]];
            } 

            if ($tookPlace == true) break;
    	}

    	// If did not placed any turn, getting available places to make a move for bot
    	if ($tookPlace==false) {
            if ( isset($defenseCoordinates) ) {
                $botCoordinates = $this->generateCoordinatesResponse($defenseCoordinates[0], $defenseCoordinates[1], $this->players[1]);
            } else {
                // if bot dont need to defense then can place a random move on available coordinates
                $botCoordinates = $this->randomCoordinates($availableTurnOptions);
            }
    	}
    	return $botCoordinates;
    }


    private function randomCoordinates($availableTurnOptions) {

        // if bot dont need to defense then can place a random move on available coordinates
        $totalAvailablePlaces = count($availableTurnOptions)-1;
        $place = rand(0, $totalAvailablePlaces);

        if (count($availableTurnOptions) == 0) {
          $botCoordinates = $this->generateCoordinatesResponse(null, null, $this->players[1], "Game Draw!");
        } else {
          $botCoordinates = $this->generateCoordinatesResponse($availableTurnOptions[$place][0], 
                                                             $availableTurnOptions[$place][1], 
                                                             $this->players[1]);
        }
        return $botCoordinates;
    }

    private function generateCoordinatesResponse($x, $y, $playerUnit, $message='') {

    	$response = [$x, $y, $playerUnit];
    	if ($message!='') $response[] = $message;
    	
    	return $response;
    }

}
