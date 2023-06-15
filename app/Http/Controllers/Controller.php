<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;



class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function validateRequest(Request $request, $rules)
    {
        $validator = Validator::make(
            $request->all(),
            $rules
        );

        if ($validator->fails()) {    
            throw new ValidationException($validator->getMessageBag());
        }
        
        $validator->validate();
        return $validator->validated();
    }
}
