<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;
use App\Facade\GameFacade;
use App\Validators\GameValidator;

class GameController extends Controller 
{

    /**
     * Create project
     * 
     * @param  \App\Models\Project $request 
     * @return json
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

}
