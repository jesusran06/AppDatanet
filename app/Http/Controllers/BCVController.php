<?php

namespace App\Http\Controllers;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class BCVController extends Controller
{
    public function getBCV()
    {
        try {
            $currencies = Http::get('https://bcv-api.deno.dev/v1/exchange');
            return response()->json($currencies->json(), Response::HTTP_OK);
        } catch (Throwable $th) {
            return response()->json(['parroquias'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        
    }
}
