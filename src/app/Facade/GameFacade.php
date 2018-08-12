<?php

namespace App\Facade;

use Illuminate\Http\Response as HttpResponse;
use App\Providers\MoveInterface;

class GameFacade implements MoveInterface
{

    public static function makeMove($boardState, $playerUnit = 'X') {

    }

}
