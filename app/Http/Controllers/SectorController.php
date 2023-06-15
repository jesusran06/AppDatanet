<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\PlanResource;
use App\Repositories\SectorRepository;
use App\Repositories\SubsectorRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;

class SectorController extends Controller
{
    public function __construct()
    {
        $this->SectorRepository = new SectorRepository();
        $this->SubsectorRepository = new SubsectorRepository();
    }
    public function index(){
        try {
            $sectors = $this->SectorRepository->getSectors();
            return response()->json($sectors, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['sectors'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }
    public function GetSelect($id){
        try {
            $sectors = $this->SectorRepository->GetSelect($id);
            return response()->json($sectors, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['sectors'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }
    public function GetSubSelect($id){
        try {
            $subsectors = $this->SubsectorRepository->GetSubSelect($id);
            return response()->json($subsectors, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['sectors'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }
    public function storeSector(Request $request) {
        try {
            $rules = [
                'name' => ['required'],
                'parroquia_id' => ['required'],
                'id'=>['nullable']
            ];
            $data = $this->validateRequest($request, $rules);
            $sector = $this->SectorRepository->saveSector($data);
            if(isset($request['subsectors'][0])){
                $subsector = $this->SubsectorRepository->saveSubsector($request['subsectors'], $sector->id);
                return response()->json(['sector' => $sector, 'subsector' => $subsector, 'message'=> 'Sector creado correctamente'], Response::HTTP_CREATED);
            } else {
                return response()->json(['sector' => $sector, 'subsector' => null, 'message'=> 'Sector creado correctamente'], Response::HTTP_CREATED);
            }
            
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
    public function deleteSector($id) {
        try {
            $this->SectorRepository->deleteSector($id);
            return response()->json(['message'=> 'Sector eliminado correctamente', 'status' => Response::HTTP_OK]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>'Error al eliminar', 'status' => Response::HTTP_CONFLICT]);
        }
    }

    public function filter($search) {
        try {
            $sectors = $this->SectorRepository->filter($search);
            return response()->json($sectors, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['sectors'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
