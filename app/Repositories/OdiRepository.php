<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\Odi;
use App\Models\ItemPrice;
use Illuminate\Support\Facades\Auth;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class OdiRepository.
 */
class OdiRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Odi::class;
    }
    
    public function newOdi($contract_id){
        $this->create([
            'contract_id' => $contract_id,
        ]);
    }

    public function index(){
        $user = Auth::user();
        
        if($user->role_id != 5 ){
            $odis = $this->with([
                            'contract', 
                            'contract.client', 
                            'contract.parroquia', 
                            'contract.nap', 
                            'contract.sector', 
                            'contract.service_request', 
                            'contract.service_request.seller', 
                            'contract.service_request.instalation',
                            'contract.plan', 
                            'instalator',
                            'contract.subsector', 
                            'contract.service_request'
                            ])
                            ->where('instalated', 0)
                            ->orderBy('instalator_id', 'asc')
                            ->orderBy('created_at', 'asc')
                            ->paginate(10);
            $odis->map(function($o){
                //dd($o);
                $o->diffDays = $o->contract->service_request->approved_date->diffInDays(Carbon::now());
            });
        }else if($user->role_id == 5){
            $odis = $this->with([
                                'contract', 
                                'contract.client', 
                                'contract.parroquia', 
                                'contract.nap', 
                                'contract.sector', 
                                'contract.service_request', 
                                'contract.service_request.seller', 
                                'contract.service_request.instalation',
                                'contract.plan', 
                                'instalator',
                                'contract.subsector', 
                                'contract.service_request'
                                ])
                                ->where('instalator_id', $user->id)
                                ->where('instalated', 0)
                                ->orderBy('instalator_id', 'asc')
                                ->orderBy('created_at', 'asc')  
                                ->paginate(10);
        }
        
        
        return $odis;
        
    }

    public function updateOdi($data, $id){
        $odi = $this->updateById($id, $data);
        $odi->update_by = Auth::user()->role_id;
        $odi->save();
        return $odi;
    }

    public function setInstalator($data, $id){
        
        $odi = $this->getById($id);
        $odi->instalator_id = $data['instalator']['id'];
        $odi->asignated_date = Carbon::now();
        $odi->save();
        return $odi;
    }

    public function listApproved(){
        $user = Auth::user();
        if($user->role_id == 1 || $user->role_id == 4 || $user->role_id == 6 || $user->role_id == 8){
            $odis = $this->with([
                            'contract', 
                            'contract.client', 
                            'contract.parroquia', 
                            'contract.nap', 
                            'contract.sector', 
                            'contract.service_request', 
                            'contract.service_request.seller', 
                            'contract.service_request.instalation',
                            'contract.plan', 
                            'instalator',
                            'contract.subsector', 
                            ])
                            ->where('instalated', 1)
                            ->orderBy('created_at', 'asc')
                            ->paginate(10);
        }else if($user->role_id == 5){
            $odis = $this->with([
                                'contract', 
                                'contract.client', 
                                'contract.parroquia', 
                                'contract.nap', 
                                'contract.sector', 
                                'contract.service_request', 
                                'contract.service_request.seller', 
                                'contract.service_request.instalation',
                                'contract.plan', 
                                'instalator',
                                'contract.subsector', 
                                ])
                                ->where('instalator_id', $user->id)
                                ->where('instalated', 1)
                                ->orderBy('created_at', 'asc')  
                                ->paginate(10);
        }
        
        
        return $odis;

    }

    public function finish($data, $id){
        $odi = $this->updateById($id, $data);
        $odi->update_by = Auth::user()->role_id;
        $odi->instalated = 1;
        $odi->instalation_date = Carbon::now();
        $odi->save();
        return $odi;
    }

    public function odiByContract($contract_id){
        $odi = $this->with('instalator')->where('contract_id', $contract_id)->first();
        return $odi;
    }

    public function odiApprove($odi_id){
        $user = Auth::user();
        $approve =  $this->updateById($odi_id, ['approved' => 1, 'approved_by' => $user->id, 'approved_date' => Carbon::now()]);
        return $approve;
    }

    public function assingGroup($request){
        
        $odis = $request->odis;
        
        $instalator = $request->instalator;
        //dd($instalator["id"]);
        foreach ($odis as $odi) {
            //dd($odi["id"]);
            $this->updateById($odi["id"], ['instalator_id' => $instalator["id"], 'asignated_date' => Carbon::now()]);
        }
        return true;
    }
    public function filter($search){
        $user = Auth::user();
        
        if($user->role_id !== 5 ){
            $odis = Odi::join('contracts', 'odis.contract_id', 'contracts.id')
                        ->join('clients', 'contracts.client_id', 'clients.id')
                        ->join('sectors', 'contracts.sector_id', 'sectors.id')
                        ->leftjoin('users', 'odis.instalator_id', 'users.id')
                        ->Where('odis.id','LIKE',"%$search%")
                        ->orWhere('contracts.social_razon','LIKE',"%$search%")
                        ->orWhere('contracts.document','LIKE',"%$search%")
                        ->orWhere('clients.celphone','LIKE',"%$search%")
                        ->orWhere('sectors.name','LIKE',"%$search%")
                        ->orWhere('clients.address','LIKE',"%$search%")
                        ->orWhere('users.name','LIKE',"%$search%")
                        ->with([
                            'contract', 
                            'contract.client', 
                            'contract.parroquia', 
                            'contract.nap', 
                            'contract.sector', 
                            'contract.service_request', 
                            'contract.service_request.seller', 
                            'contract.service_request.instalation',
                            'contract.plan', 
                            'instalator',
                            'contract.subsector'])
                        ->where('odis.instalated', 0)
                        ->select('odis.*')
                        ->orderBy('odis.created_at', 'asc')
                        ->paginate(10);
        }else if($user->role_id === 5){
            $odis = Odi::join('contracts', 'odis.contract_id', 'contracts.id')
                        ->join('clients', 'contracts.client_id', 'clients.id')
                        ->join('sectors', 'contracts.sector_id', 'sectors.id')
                        ->leftjoin('users', 'odis.instalator_id', 'users.id')
                        ->Where('odis.id','LIKE',"%$search%")
                        ->orWhere('contracts.social_razon','LIKE',"%$search%")
                        ->orWhere('contracts.document','LIKE',"%$search%")
                        ->orWhere('clients.celphone','LIKE',"%$search%")
                        ->orWhere('sectors.name','LIKE',"%$search%")
                        ->orWhere('clients.address','LIKE',"%$search%")
                        ->orWhere('users.name','LIKE',"%$search%")
                        ->with([
                            'contract', 
                            'contract.client', 
                            'contract.parroquia', 
                            'contract.nap', 
                            'contract.sector', 
                            'contract.service_request', 
                            'contract.service_request.seller', 
                            'contract.service_request.instalation',
                            'contract.plan', 
                            'instalator',
                            'contract.subsector'])
                        ->where('odis.instalated', 0)
                        ->where('instalator_id', $user->id)
                        ->select('odis.*')
                        ->orderBy('odis.created_at', 'asc')
                        ->paginate(10);
        }
        return $odis;
    }
    public function filter_approved($search) {
        $user = Auth::user();
        if($user->role_id !== 5 ){
            $odis = Odi::join('contracts', 'odis.contract_id', 'contracts.id')
                        ->join('clients', 'contracts.client_id', 'clients.id')
                        ->join('sectors', 'contracts.sector_id', 'sectors.id')
                        ->leftjoin('users', 'odis.instalator_id', 'users.id')
                        ->Where('odis.id','LIKE',"%$search%")
                        ->orWhere('contracts.social_razon','LIKE',"%$search%")
                        ->orWhere('contracts.document','LIKE',"%$search%")
                        ->orWhere('clients.celphone','LIKE',"%$search%")
                        ->orWhere('sectors.name','LIKE',"%$search%")
                        ->orWhere('clients.address','LIKE',"%$search%")
                        ->orWhere('users.name','LIKE',"%$search%")
                        ->with([
                            'contract', 
                            'contract.client', 
                            'contract.parroquia', 
                            'contract.nap', 
                            'contract.sector', 
                            'contract.service_request', 
                            'contract.service_request.seller', 
                            'contract.service_request.instalation',
                            'contract.plan', 
                            'instalator',
                            'contract.subsector'])
                        ->where('odis.instalated', 1)
                        ->select('odis.*')
                        ->orderBy('odis.created_at', 'asc')
                        ->paginate(10);
        }else if($user->role_id === 5){
            $odis = Odi::join('contracts', 'odis.contract_id', 'contracts.id')
                        ->join('clients', 'contracts.client_id', 'clients.id')
                        ->join('sectors', 'contracts.sector_id', 'sectors.id')
                        ->leftjoin('users', 'odis.instalator_id', 'users.id')
                        ->Where('odis.id','LIKE',"%$search%")
                        ->orWhere('contracts.social_razon','LIKE',"%$search%")
                        ->orWhere('contracts.document','LIKE',"%$search%")
                        ->orWhere('clients.celphone','LIKE',"%$search%")
                        ->orWhere('sectors.name','LIKE',"%$search%")
                        ->orWhere('clients.address','LIKE',"%$search%")
                        ->orWhere('users.name','LIKE',"%$search%")
                        ->with([
                            'contract', 
                            'contract.client', 
                            'contract.parroquia', 
                            'contract.nap', 
                            'contract.sector', 
                            'contract.service_request', 
                            'contract.service_request.seller', 
                            'contract.service_request.instalation',
                            'contract.plan', 
                            'instalator',
                            'contract.subsector'])
                        ->where('odis.instalated', 1)
                        ->where('instalator_id', $user->id)
                        ->select('odis.*')
                        ->orderBy('odis.created_at', 'asc')
                        ->paginate(10);
           
        }
        return $odis;
    }   

    public function getOdiById($id){
        $odi = $this->with([
            'contract', 
            'instalator', 
            'contract.client',
            'contract.parroquia',
            'contract.sector',
            'contract.subsector',
            'contract.nap',
            'contract.service_request',
            'contract.service_request.instalation',
            'contract.plan',
            'contract.service_request.seller',
        ])->getById($id);
        
            $id = 0;
            $paid_forms = array();
            $router_price = ($odi->contract->service_request->router == 1) ? ItemPrice::where('id', $odi->contract->service_request->router_id)->value('price') : 0;
            $odi->contract->service_request->invoice_total = $odi->contract->service_request->instalation->total_cost + $odi->contract->service_request->plan->price + $odi->contract->service_request->mount_cable + $odi->contract->service_request->mount_prorateo + $router_price;
            if($odi->contract->service_request->mount_cash_dl > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Divisas', 'type' => 'div', 'mount' => $odi->contract->service_request->mount_cash_dl, 'description' => $odi->contract->service_request->serials_cash_dl);
                array_push($paid_forms, $obj);
            }
            if($odi->contract->service_request->mount_cash_bs > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Bs Efectivo', 'type' => 'bs_efect', 'mount' => $odi->contract->service_request->mount_cash_bs, 'description' => "");
                array_push($paid_forms, $obj);
            }
            if($odi->contract->service_request->mount_bank_transfer > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Transferencia Bancaria', 'type' => 'bs_transf', 'mount' => $odi->contract->service_request->mount_bank_transfer, 'description' => $odi->contract->service_request->serial_bank_transfer);
                array_push($paid_forms, $obj);
            }
            if($odi->contract->service_request->mount_zelle > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Zelle', 'type' => 'zelle', 'mount' => $odi->contract->service_request->mount_zelle, 'description' => $odi->contract->service_request->serial_zelle."/".$odi->contract->service_request->titular_zelle);
                array_push($paid_forms, $obj);
            }
            if($odi->contract->service_request->mount_movil_paid > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Pago Movil', 'type' => 'pago_movil', 'mount' => $odi->contract->service_request->mount_movil_paid, 'description' => $odi->contract->service_request->serial_movil_paid);
                array_push($paid_forms, $obj);
            }
            if($odi->contract->service_request->mount_point > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Pago por Punto', 'type' => 'pago_punto', 'mount' => $odi->contract->service_request->mount_point, 'description' => $odi->contract->service_request->serial_point);
                array_push($paid_forms, $obj);
            }
            $odi->contract->service_request->paid_forms = $paid_forms;
            
        
        return $odi;
    }

}
