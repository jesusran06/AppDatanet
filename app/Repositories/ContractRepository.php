<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Contract;
use Illuminate\Support\Facades\Auth;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ContractRepository.
 */
class ContractRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Contract::class;
    }

    public function createNewContract($data){
        $contract = $this->create([
            'type_client' => $data["type_client"],
            'social_razon' => $data["social_razon"],
            'document' => $data["document"],
            'service_request_id' => $data["service_request_id"],
            'parroquia_id' => $data["parroquia_id"],
            'client_id' => $data["client_id"],
            'sector_id' => $data["sector_id"],
            'subsector_id' => $data["subsector_id"],
            'nap_id' => $data["nap_id"],
            'gps' => $data["gps"],
            'plan_id' => $data["plan_id"],
            'start_contract' => now(),
            'balance' => $data["balance"],
            'balance_dls' => $data["balance_dls"],
            
        ]);
        $id  = $contract->id;
        $contract->nro = 3306 + $contract->id;
        $mesActual = (Carbon::now()->month < 10) ? "0".Carbon::now()->month : Carbon::now()->month;
        $contract->nro_contract = "SCR-".$mesActual."-".$contract->nro;
        $contract->save();
        return $contract;

    }

    public function index(){
        $user = Auth::user();
        if($user->role_id == 1){
            $contracts = $this->with([
                'client', 
                'plan', 
                'parroquia', 
                'sector', 
                'nap',
                'subsector'
                ])
                ->orderBy('created_at', 'asc')
                ->paginate(15);
            return $contracts;
        }else{
            return $contracts = [];
        }
    }

    public function getContractById($id){
        $contract = $this->with([
            'client', 
            'plan', 
            'parroquia', 
            'sector', 
            'subsector',
            'nap',
            'service_request',
            'service_request.seller'
        ])->getById($id);
        return $contract;
    }
    public function filter($search){
        $contracts = Contract::join('plans', 'contracts.plan_id', 'plans.id')
        ->join('naps', 'contracts.nap_id', 'naps.id')
        ->join('clients', 'contracts.client_id', 'clients.id')
        ->join('sectors', 'contracts.sector_id', 'sectors.id')
        ->Where('contracts.social_razon','LIKE',"%$search%")
        ->orWhere('contracts.parroquia_id','LIKE',"%$search%")
        ->orWhere('contracts.parroquia_id','LIKE',"%$search%")
        ->orWhere('clients.address','LIKE',"%$search%")
        ->orWhere('sectors.name','LIKE',"%$search%")
        ->orWhere('plans.name','LIKE',"%$search%")
        ->orWhere('contracts.balance_dls','LIKE',"%$search%")
        ->with([
            'client', 
            'plan', 
            'parroquia', 
            'sector', 
            'nap',
            'service_request'
        ])
        ->select('contracts.*')->paginate(10);
        return $contracts;
    }
    public function activate($id){
        $approve =  $this->updateById($id, ['active' => 1]);
        return $approve;
    }

    public function updateNapInContract($nap_id, $id){
        $contract = $this->updateById($id, ['nap_id' => $nap_id]);
        return $contract;
    }

    public function updateBalance($data, $id){
        //dd($data);
        $contract = $this->getById($id);
        $balance_dls = $contract->balance_dls + $data['balance_dls'];
        $balance = $contract->balance + $data['balance'];
        $contract->balance_dls = $balance_dls;
        $contract->balance = $balance;
        if($contract->balance_dls >= 0){
            $contract->active = 1;
        }
        $contract->save();
        
    }
}
