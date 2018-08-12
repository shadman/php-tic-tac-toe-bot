<?php

namespace App\Validators;

use Validator;

class GameValidator
{


    public static function move($parameters)
    {
        $rules =  array(
            'name'    => 'required|max:200'
        );
        
        return Validator::make($parameters, $rules);
    }

}
