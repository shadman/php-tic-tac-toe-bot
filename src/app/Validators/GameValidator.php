<?php

namespace App\Validators;

use Validator;

class GameValidator
{


    public static function move($parameters)
    {
        $rules =  array(
            'boardState'    => 'required|array|min:3',
            'playerUnit'    => 'required|string|max:1'
        );
        
        return Validator::make($parameters, $rules);
    }

}
