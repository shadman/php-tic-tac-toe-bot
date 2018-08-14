<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;
use App\Facade\GameFacade;
use App\Validators\GameValidator;

class GameController extends Controller 
{

    /**
     * Play a game by posting moves
     * 
     * @param  $request 
     * @return array
     */
    public function play(Request $request){

        $parameters = $request->json()->all();
        
        $validator = GameValidator::move($parameters);
        if (!$validator->fails()) {
            $gameFacade = new GameFacade;
            return $gameFacade->makeMove($parameters['boardState'], $parameters['playerUnit']);
        }

        // Bad Request response
        return response()->json('Input validation failed', HttpResponse::HTTP_BAD_REQUEST);
        
    }

    

    /**
     * Get a matriz size to draw a board
     * 
     * @param  $request 
     * @return integer
     */
    public function matrixSize(Request $request) {

        // return max size of defined game matrix
        return response()->json(config('app.matrix'), HttpResponse::HTTP_OK);

    }

}
