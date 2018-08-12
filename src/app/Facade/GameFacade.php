<?php

namespace App\Facade;

use Illuminate\Http\Response as HttpResponse;
use App\Providers\MoveInterface;

class GameFacade implements MoveInterface
{

    public function makeMove($boardState, $playerUnit = 'X') {
    	return [];
    }

}
