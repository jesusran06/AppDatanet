<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Resources\PlanResource;
use App\Repositories\PlanRespository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;


class PlansController extends Controller
{
    //

    public function __construct()
    {
        $this->planRepository = new PlanRespository();
    }


    public function index(){
        try {
            $plans = $this->planRepository->getPlans();
            
        } catch (\Throwable $th) {
            return response()->json(['plans'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return response()->json($plans, Response::HTTP_OK);
    }

    public function store(Request $request) {
        try {
            $request['active'] = $request['active'] ? 1 : 0 ;
            $rules = [
                'name' => ['required'],
                'description' => [],
                'price' => ['required'],
                'active' => [],

            ];
            $data = $this->validateRequest($request, $rules);

            $plan = $this->planRepository->storePlan($data);
            return response()->json(['plan' => $plan, 'message'=> 'Agregado con Exito'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function update(Request $request, $id){
        try {
            
            $request['active'] = $request['active'] ? 1 : 0 ;
            $rules = [
                'name' => ['required'],
                'description' => [],
                'price' => ['required'],
                'active' => [],

            ];
            $data = $this->validateRequest($request, $rules);

            $plan = $this->planRepository->updatePlan($id, $data);
            return response()->json(['plan' => $plan, 'message'=> 'Actualizado con Exito'], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id){
        $plan =  $this->planRepository->disable($id);
        if($plan){
            return response()->json(['status' => Response::HTTP_OK]);
        }else{
            return response()->json(['status' => Response::HTTP_CONFLICT]);
        }
    }

    public function filterPlans($search) {
        try {
            $plans = $this->planRepository->filter($search);
            return response()->json($plans, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['plans'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
