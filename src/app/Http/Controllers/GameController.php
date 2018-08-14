<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response as HttpResponse;
use Illuminate\Http\Request;
use App\Facade\GameFacade;
use App\Validators\GameValidator;

class GameController extends Controller 
{
    
    /**
     * @api {POST} /v1/move Make a Move
     * @apiVersion 1.0.0
     * @apiName Make a Move
     * @apiGroup Game
     * @apiHeader {String} Content-Type application/json
     *
     * @apiParamExample {json} Request-Example:
     * {
     *   "boardState" : [["O","","X"],["","","O"],["","X",""]],
     *   "playerUnit" : "X"
     * }
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *  
     * [1,0,"O"]
     *
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
     * @api {GET} /v1/matrix Matrix Size
     * @apiVersion 1.0.0
     * @apiName Matrix Size
     * @apiGroup Game
     * @apiHeader {String} Content-Type application/json
     *
     * @apiSuccessExample {json} Success-Response:
     * HTTP/1.1 200 OK
     *  
     * @return integer
     */
    public function matrixSize(Request $request) {

        // return max size of defined game matrix
        return response()->json(config('app.matrix'), HttpResponse::HTTP_OK);

    }

}
