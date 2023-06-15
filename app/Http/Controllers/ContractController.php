<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMail;
use Illuminate\Http\Request;
use App\Repositories\OdiRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Repositories\ClientsRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\ContractRepository;
use Symfony\Component\HttpFoundation\Response;
use App\Repositories\ServiceRequestsRepository;
use App\Repositories\InvoiceItemDetailRepository;

class ContractController extends Controller
{
    public function __construct(){

        $this->contractRepository = new ContractRepository();
        $this->clientRepository = new ClientsRepository();
        $this->serviceRequestsRepository  = new ServiceRequestsRepository();
        $this->odiRepository = new OdiRepository();
        $this->invoiceRepository = new InvoiceRepository();
        $this->invoiceItemDetailRepository = new InvoiceItemDetailRepository();
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $contracts = $this->contractRepository->index();
            
        } catch (\Throwable $th) {
            return response()->json(['contracts'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($contracts, Response::HTTP_OK);
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
        //
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

    public function approve_sale(Request $request){
        try {
            $currencies = Http::get('https://bcv-api.deno.dev/v1/exchange');
            $dls = $currencies->json();
            $dls_today = $dls[0]["exchange"];
        } catch (\Throwable $th) {
            return response()->json(["error" => "Error en respuesta del precio del Dolar", "code" => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
        //Calculo de Balance o Saldo del contrato del cliente, resta de el monto recibido menos el costo de la instalacion
        $balance_bs = floatval($request["total_bs_received"]) - floatval(floatval($request["instalation"]["total_cost"] * $dls_today));
        $balance_dls = floatval($request["total_dls_received"]) - floatval($request["instalation"]["total_cost"]);
        try {
            $client = [
                'names' => $request["typeClient"]=='N'? $request["names"] : $request["name"],
                'document' => $request["typeClient"]=='N'? $request["document2"] : $request["document"],
                'birthdate' => $request["typeClient"]=='N'? $request["birthdate"] : null,
                'last_names' => $request["typeClient"]=='N'? $request["last_names"] : null,
                'address' => $request["address"],
                'parroquia_id' => $request["parroquia"]['id'],
                'sector_id' => $request["sector"]['id'],
                'subsector_id' => $request['subsector']['id'],
                'celphone' => $request["celphone"],
                'whatsapp' => $request["whatsapp"],
                'email' => $request["email"],
                'type_client' => $request["typeClient"],
            ];
           
            $the_cliente = $this->clientRepository->createClient($client);
            $contract = [
                'type_client' => $request["typeClient"],
                'social_razon' => $request["typeClient"]=='N'? $request["names"].' '.$request["last_names"] : $request["name"],
                'document' => $request["typeClient"]=='N'? $request["document2"] : $request["document"],
                'service_request_id' => $request["id"],
                'parroquia_id' => $request["parroquia"]['id'],
                'client_id' => $the_cliente->id,
                'sector_id' => $request["sector"]['id'],
                'subsector_id' => $request['subsector']['id'],
                'nap_id' => $request["nap"]?$request["nap"]['id']:null,
                'gps' => $request["gps"],
                'plan_id' => $request["plan"]['id'],
                'start_contract' => now(),
                'balance' => $balance_bs,
                'balance_dls' => $balance_dls,
    
            ];
            $newContract = $this->contractRepository->createNewContract($contract);
            $this->odiRepository->newOdi($newContract->id);
            $approve = $this->serviceRequestsRepository->approve($request["id"], $the_cliente->id, $newContract->nro_contract);
            $data_invoice = [
                'client_id' => $the_cliente->id,
                'contract_id' => $newContract->id,
                'plan' => $request["plan"],
                'instalation' => $request["instalation"],
                'total_dls_received' => $request["total_dls_received"],
                'total_bs_received' => $request["total_bs_received"],
            ];
            $invoice = $this->invoiceRepository->createSaleInvoice($data_invoice);

            
            $data_invoice_detail = [
                'invoice_id' => $invoice->id,
                'plan' => $request["plan"],
                'instalation' => $request["instalation"],

            ];
            
            $this->invoiceItemDetailRepository->createSaleInvoice($data_invoice_detail, $dls_today);
            /** Envio de correo de bienvenida */
            $this->sendWelcomeEmail($the_cliente, $newContract);
            return response()->json(['client'=> $the_cliente, 'contract' => $newContract, 'approve' =>$approve, 'code' => Response:: HTTP_CREATED],  Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage(), "code" => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
       
    }

    public function getById($id){
        try {
            $contract = $this->contractRepository->getContractById($id);
        } catch (\Throwable $th) {
            return response()->json(["error" => $th->getMessage(), "code" => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
        }
        return $contract;
    }
    public function filter($search) {
        try {
            $contracts = $this->contractRepository->filter($search);
            return response()->json($contracts, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json(['plans'=> null, 'message'=>$th->getMessage()],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function sendWelcomeEmail($client, $contract)
    {
        $sendMail = Mail::to($client->email)->send(new WelcomeMail($contract->social_razon));
        return $sendMail;
    }

}
