<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\AdditionalServiceRepository;

class AdditionalServiceController extends Controller
{
    //
    public function __construct()
    {
        $this->additionalServiceRepository = new AdditionalServiceRepository();
    }

    public function index(){
        try {
            $services = $this->additionalServiceRepository->getAll();
        } catch (\Throwable $th) {
            return response()->json(['services'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json($services, Response::HTTP_OK);
    }
}
