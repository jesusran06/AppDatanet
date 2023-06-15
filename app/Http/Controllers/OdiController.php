<?php

namespace App\Http\Controllers;
use  PDF;
use Carbon\Carbon;
use App\Models\Odi;
use App\Exports\OdiExport;
use Illuminate\Http\Request;
use App\Http\Resources\OdiResource;
use App\Repositories\OdiRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Repositories\ContractRepository;
use Symfony\Component\HttpFoundation\Response;


class OdiController extends Controller
{

    public function __construct()
    {
        $this->odiRepository = new OdiRepository();
        $this->contractRepository = new ContractRepository();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $odis = $this->odiRepository->index();
        } catch (\Throwable $th) {
            return response()->json(['odis'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($odis, Response::HTTP_OK);
    }

    public function odiGenerate($id){
        $data =  Odi::find($id)->with(['contract', 'contract.client', 'contract.parroquia', 'contract.nap', 'contract.sector']);
        $paperSize = [0, 0, 612, 936];
        $pdf =  PDF::loadView('PDF.odi', ['data' => $data])->setPaper($paperSize, 'portrait');
        //dd($pdf);
        return $pdf->download('certificado.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
                'reel' => [],
                'reel_start_mts' => [],
                'reel_end_mts' => [],
                'total_distance' => [],
                'nap_port' => [],
                'nap_potency' => [],
                'fast_conector' => [],            
                'pgtail' => [],
                'strapping' => [],
                'hoops' => [],
                'heat_shrinkable' => [],
                'rosettes' => [],
                'staples' => [],
                'client_potency' => [],
                'return_potency' => [],
                'onu_serial' => [],
                'instalation_date' => [],
                'observations' => [],
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
                'titular_zelle' => [],  
            ]);
            $odis = $this->odiRepository->updateOdi($validatedData, $id);
            $this->contractRepository->updateNapInContract($request->nap, $request->contract["id"]);
        
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message'  => "ODI actualizado", 'odi' => $odis], Response::HTTP_CREATED);
        
    }

    public function finish(Request $request, $id){
        try {
            $currencies = Http::get('https://bcv-api.deno.dev/v1/exchange');
            $dls = $currencies->json();
            $dls_today = $dls[0]["exchange"];
        } catch (\Throwable $th) {
            return response()->json(["error" => "Error en respuesta del precio del Dolar", "code" => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
        try {
            //dd($request);
            $validatedData = $request->validate([
                'reel' => [],
                'reel_start_mts' => [],
                'reel_end_mts' => [],
                'total_distance' => [],
                'nap_port' => [],
                'nap_potency' => [],
                'fast_conector' => [],            
                'pgtail' => [],
                'strapping' => [],
                'hoops' => [],
                'heat_shrinkable' => [],
                'rosettes' => [],
                'staples' => [],
                'client_potency' => [],
                'return_potency' => [],
                'onu_serial' => [],
                'instalation_date' => [],
                'observations' => [],
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
                'total_dls_received' => [],    
                'total_bs_received' => [],  
                'amount_total' => [],   
                'titular_zelle' => [],   
                
            ]);
            //Calculo de Balance o Saldo del contrato del cliente, resta de el monto recibido menos el costo de la instalacion
        $balance_bs = floatval($request["total_bs_received"]) - floatval(floatval($request["amount_total"] * $dls_today));
        $balance_dls = floatval($request["total_dls_received"]) - floatval($request["amount_total"]);
        $contract = [
            'balance' => $balance_bs,
            'balance_dls' => $balance_dls,

        ];
        $odis = $this->odiRepository->finish($validatedData, $id);
        $contract_id = $request["contract"]["id"];
        $this->contractRepository->updateBalance($contract, $contract_id);
        } catch (\Throwable $th) {
            return response()->json(['message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json(['message'  => "ODI actualizado", 'odi' => $odis], Response::HTTP_CREATED);

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

    public function setInstalator(Request $request, $id){
       try{ 
        $validatedData = $request->validate([
            'instalator' => [],
        ]);
        $odis = $this->odiRepository->setInstalator($validatedData, $id);
    
    } catch (\Throwable $th) {
        return response()->json(['message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
    }
    return response()->json(['message'  => "Instalador Asignado", 'odi' => $odis], Response::HTTP_CREATED);

    }

    public function listApproved(){
        try {
            $odis = $this->odiRepository->listApproved();
        } catch (\Throwable $th) {
            return response()->json(['odis'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($odis, Response::HTTP_OK);
    }

    public function odiByContract($contract_id){
        try {
            $odi = $this->odiRepository->odiByContract($contract_id);
        } catch (\Throwable $th) {
            return response()->json(['odi'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($odi, Response::HTTP_OK);
    }

    public function approve(Request $request, $odi_id){
        //dd($request);
        try {
            $odi = $this->odiRepository->odiApprove($odi_id);
            $this->contractRepository->activate($request->contract_id);
        } catch (\Throwable $th) {
            return response()->json(['odi'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($odi, Response::HTTP_OK);
    }

    public function assingGroup(Request $request){
        try {
            $odi = $this->odiRepository->assingGroup($request);

        }catch(\Throwable $th){
            return response()->json(['odi'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($odi, Response::HTTP_OK);
    }
    public function filter($search){
        try {
            $odis = $this->odiRepository->filter($search);
            return response()->json($odis, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['odis'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function filter_approved($search){
        
        try {
            $odis = $this->odiRepository->filter_approved($search);
            return response()->json($odis, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['odis'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getById($id){
        try {
            $odi = $this->odiRepository->getOdiById($id);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage(), "code" => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
        return $odi;
    }

    public function odiReport(Request $request) {
        try {
            
            $odis =  Odi::with([
                    'contract',
                    'contract.client',
                    'contract.sector',
                    'contract.subsector',
                    'contract.nap',
                    'contract.plan',
                    'instalator'
                ]);
            $now = Carbon::now()->format('Y-m-d');
            $hasta = ($request->hasta == '') ? $now : $request->hasta;

            if (($request->desde != null) && ($hasta != null)) {
                $odis = $odis->whereRaw("DATE(instalation_date) BETWEEN '" . $request->desde . "'" . " AND " . "'" . $hasta . "'");
                
            }
            if(!is_null($request->instalator) ){
                $odis = $odis->whereIn('instalator_id', $request->instalator);
            }
            
            
            $odis->whereHas('contract', function ($query) use ($request) {
                if ($request->subsector != "" && $request->subsector == "") {
                    $query->where('subsector_id', '=', $request->subsector);
                }
            });
            $odis->whereHas('contract', function ($query) use ($request) {
                if ($request->sector != "" && $request->subsector == "") {
                    $query->where('sector_id', '=', $request->sector);
                }
            });
            $odis->whereHas('contract', function ($query) use ($request) {
                if ($request->parroquia != "" && $request->parroquia == "") {
                    $query->where('parroquia_id', '=', $request->parroquia);
                }
            });
            /*if($request->sector != "" && $request->subsector == ""){
                $odis = $odis->where('contract.sector_id', '=', $request->sector);
                
            }
            if($request->parroquia != ""&& $request->sector == ""){
                $odis = $odis->where('contract.parroquia_id', '=', $request->parroquia);
            }*/
            $odis = $odis->orderBy('created_at', 'DESC')->paginate();
            //return $sales;
            
            return response()->json($odis, Response::HTTP_OK);

        }catch(\Throwable $th){
            return response()->json(['request'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    public function export_report(Request $request){
        if (ob_get_contents()) ob_end_clean();
        ob_start();
        return (new OdiExport($request))->download('report.xlsx');
    }

}
