<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\NapsRepository;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\ValidationException;
class NapsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
    {
        $this->NapsRepository = new NapsRepository();
    }
    public function index()
    {
        try {
            $naps = $this->NapsRepository->getNaps();
            return response()->json($naps, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['naps'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        } 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $rules = [
                'name' => ['required'],
                'address'=>[],
                'sector_id'=>['required'],
                'nro'=>['required'],
                'subsector_id'=>[],
            ];
            $data = $this->validateRequest($request, $rules);
            $nap = $this->NapsRepository->createNap($data);
            return response()->json(['NAP' => $nap, 'message'=> 'NAP creada correctamente'], Response::HTTP_CREATED);
            
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $rules = [
                'name' => ['required'],
                'address'=>[],
                'sector_id'=>['required'],
                'nro'=>['required'],
                'subsector_id'=>[],
            ];
            $data = $this->validateRequest($request, $rules);
            $nap = $this->NapsRepository->updateNap($data, $id);
            return response()->json(['NAP' => $nap, 'message'=> 'NAP actualizada correctamente'], Response::HTTP_CREATED);
            
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function Delete($id)
    {
        try {
            $nap = $this->NapsRepository->deleteNap($id);
            return response()->json(['NAP' => $nap, 'message'=> 'NAP eliminada correctamente'], Response::HTTP_CREATED);
            
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAll(){
        try {
            $naps = $this->NapsRepository->getAll();
            return response()->json($naps, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['naps'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }         
    }
    public function filter($search) {
        try {
            $naps = $this->NapsRepository->filter($search);
            return response()->json($naps, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['naps'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
