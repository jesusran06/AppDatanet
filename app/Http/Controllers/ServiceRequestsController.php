<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Exports\ServiceRequestExport;
use App\Http\Resources\ServiceRequestResource;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\API\V1\BaseController;
use App\Repositories\ServiceRequestsRepository;

class ServiceRequestsController extends Controller
{
    public function __construct()
    {
        $this->serviceRequestsRepository = new ServiceRequestsRepository();
        $baseController = new BaseController();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $service_request = $this->serviceRequestsRepository->index();
            //$service_request = ServiceRequest::with('seller', 'client', 'plan')->paginate(10);
            
        } catch (\Throwable $th) {
            return response()->json(['service_request'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return response()->json($service_request, Response::HTTP_OK);
    }

    public function list_approved()
    {
        try {
            $service_request = $this->serviceRequestsRepository->list_approved();
            //$service_request = ServiceRequest::with('seller', 'client', 'plan')->paginate(10);
            
        } catch (\Throwable $th) {
            return response()->json(['service_request'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        
        return response()->json($service_request, Response::HTTP_OK);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        try {
            $validatedData = $request->validate([
                'num_form' => ['required'],
                'name' => [],
                'address' => ['required'],
                'document' => [],
                'document2' => [],
                'names' => [],
                'last_names' => [],
                'sector' => ['required'],
                'subsector' => ['required'],
                'celphone' => ['required'],
                'whatsapp' => [],
                'email' => ['required'],
                'plan' => ['required'],
                'instalation' => ['required'],
                'parroquia' => ['required'],
                'typeClient' => [],
                'questionnaire' => [],
                'observations' => [],
                'nap' => [],
                'distance' => [],
                'gps' => [],
                'mount_cash_dl' => [],
                'serials_cash_dl' => [],
                'mount_cash_bs' => [],
                'serials_cash_bs' => [],
                'mount_bank_transfer' => [],
                'serial_bank_transfer' => [],
                'mount_zelle' => [],
                'serial_zelle' => [],
                'mount_movil_paid' => [],
                'serial_movil_paid' => [],
                'mount_point' => [],
                'serial_point' => [],
                'birthdate' => [],
                'total_bs_received' => [],
                'total_dls_received' => [],
                'router' => [],
                'router_model' => [],
                'router_serial' => [],
                'cable' => [],
                'mount_cable' => [],
                'prorateo' => [],
                'mount_prorateo' => [],
                'change_operators' => [],
                'operator' => [],
                'titular_zelle' => [],
            ]);
            $request_service = $this->serviceRequestsRepository->store($validatedData);
            return response()->json(['message'  => "Venta creada",  'code' => Response:: HTTP_CREATED], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage(), "code" => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'num_form' => ['required'],
                'name' => [],
                'address' => ['required'],
                'document' => [],
                'document2' => [],
                'names' => [],
                'last_names' => [],
                'sector' => ['required'],
                'subsector' => ['required'],
                'celphone' => ['required'],
                'whatsapp' => [],
                'email' => ['required'],
                'plan' => ['required'],
                'instalation' => ['required'],
                'parroquia' => ['required'],
                'typeClient' => [],
                'questionnaire' => [],
                'observations' => [],
                'nap' => [],
                'distance' => [],
                'gps' => [],
                'mount_cash_dl' => [],
                'serials_cash_dl' => [],
                'mount_cash_bs' => [],
                'serials_cash_bs' => [],
                'mount_bank_transfer' => [],
                'serial_bank_transfer' => [],
                'mount_zelle' => [],
                'serial_zelle' => [],
                'mount_movil_paid' => [],
                'serial_movil_paid' => [],
                'mount_point' => [],
                'serial_point' => [],
                'birthdate' => [],
                'total_bs_received' => [],
                'total_dls_received' => [],
                'router' => [],
                'router_model' => [],
                'router_serial' => [],
                'cable' => [],
                'mount_cable' => [],
                'prorateo' => [],
                'mount_prorateo' => [],
                'change_operators' => [],
                'operator' => [],
                'titular_zelle' => [],
            ]);
            $request_service = $this->serviceRequestsRepository->updateService($validatedData, $id);
            return response()->json(['message'  => "Venta actualizada", 'request_service' => $request_service], Response::HTTP_CREATED);
            
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
        try {
            $request = $this->serviceRequestsRepository->destroy($id);
            return response()->json(['message'  => "Venta Eliminada!",  'code' => Response:: HTTP_OK], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage(), "code" => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
    }

    public function filterAllSales($search) {
        try {
            $request = $this->serviceRequestsRepository->filterAllSales($search);
            return response()->json($request, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['request'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function filterSalesApproved($search) {
        try {
            $request = $this->serviceRequestsRepository->filterSalesApproved($search);
            return response()->json($request, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['request'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function salesReport(Request $request) {
        try {
            //$sales = $this->serviceRequestsRepository->salesReport($request);
                $sales =  ServiceRequest::with([
                    'seller', 
                    'client', 
                    'plan', 
                    'parroquia', 
                    'sector', 
                    'nap', 
                    'instalation',
                    'subsector',
                    'contract',
                    'juridict_contract',
                    'router_model'
                ]);
            $now = Carbon::now()->format('Y-m-d');
            $hasta = ($request->hasta == '') ? $now : $request->hasta;

            if (($request->desde != null) && ($hasta != null)) {
                $sales = $sales->whereRaw("DATE(created_at) BETWEEN '" . $request->desde . "'" . " AND " . "'" . $hasta . "'");
                
            }
            if(!is_null($request->seller) ){
                $sales = $sales->whereIn('seller_id', $request->seller);
            }
            
            
            if($request->subsector != "" ){
                $sales = $sales->where('subsector_id', $request->subsector);
            }
            
            if($request->sector != "" && $request->subsector == ""){
                $sales = $sales->where('sector_id', $request->sector);
                
            }
            if($request->parroquia != ""&& $request->sector == ""){
                $sales = $sales->where('parroquia_id', $request->parroquia);
            }
            $sales = $sales->orderBy('created_at', 'DESC')->paginate();
            //return $sales;
            
            return response()->json($sales, Response::HTTP_OK);

        }catch(\Throwable $th){
            return response()->json(['request'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function export_report(Request $request){
        if (ob_get_contents()) ob_end_clean();
        ob_start();
        return (new ServiceRequestExport($request))->download('report.xlsx');
    }

}
