<?php

namespace App\Repositories;

use Carbon\Carbon;
use App\Models\ItemPrice;
use App\Models\ServiceRequest;

use function PHPSTORM_META\map;
use Illuminate\Support\Facades\Auth;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

//use Your Model

/**
 * Class ServiceRequestsRepository.
 */
class ServiceRequestsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ServiceRequest::class;
    }

    public function index(){
        $user = Auth::user();
        if($user->role_id == 1 || $user->role_id == 3 || $user->role_id == 7){
            $service_request = $this->with([
                                    'seller', 
                                    'client', 
                                    'plan', 
                                    'parroquia', 
                                    'sector', 
                                    'nap', 
                                    'instalation',
                                    'subsector',
                                    'operator',
                                    'router_model'
                                    ])
                                    ->where('approved', 0)
                                    ->orderBy('created_at', 'asc')
                                    ->paginate(10);
        }else if($user->role_id == 2){
            $service_request = $this->with([
                                    'seller', 
                                    'client', 
                                    'plan', 
                                    'parroquia', 
                                    'sector', 
                                    'nap', 
                                    'instalation',
                                    'subsector',
                                    'operator',
                                    'router_model'
                                    ])
                                    ->where('seller_id', $user->id)
                                    ->where('approved', 0)
                                    ->orderBy('created_at', 'asc')
                                    ->paginate(10);
        }
        $service_request->map(function($o){
            $o->questionnaire =  json_decode($o->questionnaire, true);
        });
        
        return $service_request;
    }

    public function list_approved(){
        $user = Auth::user();
        if($user->role_id == 1 || $user->role_id == 3 || $user->role_id == 7){
            $service_request = $this->with([
                                    'seller', 
                                    'client', 
                                    'plan', 
                                    'parroquia', 
                                    'sector', 
                                    'nap', 
                                    'instalation',
                                    'subsector',
                                    'contract',
                                    'operator',
                                    'juridict_contract',
                                    'router_model'
                                    ])
                                    ->where('approved', 1)
                                    
                                    ->orderBy('created_at', 'asc')
                                    ->paginate(10);
        }else if($user->role_id == 2){
            $service_request = $this->with([
                                    'seller', 
                                    'client', 
                                    'plan', 
                                    'parroquia', 
                                    'sector', 
                                    'nap', 
                                    'instalation',
                                    'subsector',
                                    'contract',
                                    'operator',
                                    'juridict_contract',
                                    'router_model'
                                    ])
                                    ->where('seller_id', $user->id)
                                    
                                    ->where('approved', 1)
                                    ->orderBy('created_at', 'asc')
                                    ->paginate(10);
        }
        
        $service_request->map(function($o){
            $id = 0;
            $paid_forms = array();
            $o->questionnaire =  json_decode($o->questionnaire, true);
            $router_price = ($o->router == 1) ? ItemPrice::where('id', $o->router_id)->value('price') : 0;
            $o->invoice_total = $o->instalation->total_cost + $o->plan->price + $o->mount_cable + $o->mount_prorateo + $router_price;
            if($o->mount_cash_dl > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Divisas', 'type' => 'div', 'mount' => $o->mount_cash_dl, 'description' => $o->serials_cash_dl);
                array_push($paid_forms, $obj);
            }
            if($o->mount_cash_bs > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Bs Efectivo', 'type' => 'bs_efect', 'mount' => $o->mount_cash_bs, 'description' => "");
                array_push($paid_forms, $obj);
            }
            if($o->mount_bank_transfer > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Transferencia Bancaria', 'type' => 'bs_transf', 'mount' => $o->mount_bank_transfer, 'description' => $o->serial_bank_transfer);
                array_push($paid_forms, $obj);
            }
            if($o->mount_zelle > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Zelle', 'type' => 'zelle', 'mount' => $o->mount_zelle, 'description' => $o->serial_zelle."/".$o->titular_zelle);
                array_push($paid_forms, $obj);
            }
            if($o->mount_movil_paid > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Pago Movil', 'type' => 'pago_movil', 'mount' => $o->mount_movil_paid, 'description' => $o->serial_movil_paid);
                array_push($paid_forms, $obj);
            }
            if($o->mount_point > 0){
                $obj = (object) array('id' => $id++, 'name' => 'Pago por Punto', 'type' => 'pago_punto', 'mount' => $o->mount_point, 'description' => $o->serial_point);
                array_push($paid_forms, $obj);
            }
            $o->paid_forms = $paid_forms;
            
        });
        
        return $service_request;
    }

    public function store($data){
        $request_service = $this->create([
            'type_client' => strtoupper($data['typeClient']),
            'social_razon' => (strtoupper($data['typeClient']) === 'N') ? strtoupper($data['names']).' '.strtoupper($data['last_names']) : strtoupper($data['name']),
            'document' => $data['document'],
            'names' => strtoupper($data['names']),
            'last_names' => strtoupper($data['last_names']),
            'document2' => $data['document2'],
            'birthdate' => $data['birthdate'] ? $data['birthdate'] : null,
            'address' => strtoupper($data['address']),
            'parroquia_id' => $data['parroquia']['id'],
            'sector_id' => $data['sector']['id'],
            'subsector_id' => $data['subsector']['id'],
            'celphone' => $data['celphone'],
            'whatsapp' => $data['whatsapp'],
            'email' => strtoupper($data['email']),
            'nap_id' => $data['nap'] ? $data['nap']['id'] : null,
            'distance' => $data['distance'],
            'gps' => $data['gps'],
            'approved' => 0,
            'seller_id' => Auth::user()->id,
            'plan_id' => $data['plan']['id'],
            'instalation_id' => $data['instalation']['id'],
            'questionnaire' => json_encode($data['questionnaire'] ? $data['questionnaire'] : null),
            'observations' => strtoupper($data['observations']),
            'num_form' => $data['num_form'],
            'mount_cash_dl' => $data['mount_cash_dl'],
            'serials_cash_dl' => $data['serials_cash_dl'],
            'mount_cash_bs' => $data['mount_cash_bs'],
            'serials_cash_bs' => $data['serials_cash_bs'],
            'mount_bank_transfer' => $data['mount_bank_transfer'],
            'serial_bank_transfer' => $data['serial_bank_transfer'],
            'mount_zelle' => $data['mount_zelle'],
            'serial_zelle' => strtoupper($data['serial_zelle']),
            'mount_movil_paid' => $data['mount_movil_paid'],
            'serial_movil_paid' => strtoupper($data['serial_movil_paid']),
            'mount_point' => $data['mount_point'],
            'serial_point' => strtoupper($data['serial_point']),
            'total_bs_received' => $data['total_bs_received'],
            'total_dls_received' => $data['total_dls_received'],
            'router' => $data['router'],
            'router_id' => ($data['router_model']) ? $data['router_model']['id'] : null,
            'router_model' => ($data['router_model']) ? $data['router_model']['name'] : null,
            'router_serial' => $data['router_serial'],
            'cable' => $data['cable'],
            'mount_cable' => $data['mount_cable'],
            'prorateo' => $data['prorateo'],
            'mount_prorateo' => $data['mount_prorateo'],
            'change_operators' => ($data['operator'] ? true : false),
            'operator_id' => ($data['operator'] ? $data['operator']['id'] : null),
            'titular_zelle' => $data['titular_zelle']

        ]);
        return  $request_service;

    }

    public function updateService($data, $id){
        if(is_string($data['router_model'])){
            $router_name = $data['router_model'];
        }elseif($data['router_model']){
            $router_name = $data['router_model']['name'];
            $router_id = $data['router_model']['id'];
        }else{
            $router_name = null;
            $router_id = null;
        }
        $service = $this->updateById($id, 
        ['type_client' => strtoupper($data['typeClient']),
        'social_razon' => strtoupper($data['name']),
        'document' => $data['document'],
        'names' => strtoupper($data['names']),
        'last_names' => strtoupper($data['last_names']),
        'document2' => $data['document2'],
        'birthdate' => $data['birthdate'] ? $data['birthdate'] : null,
        'address' => strtoupper($data['address']),
        'parroquia_id' => $data['parroquia']['id'],
        'sector_id' => $data['sector']['id'],
        'subsector_id' => $data['subsector']['id'],
        'celphone' => $data['celphone'],
        'whatsapp' => $data['whatsapp'],
        'email' => strtoupper($data['email']),
        'nap_id' => $data['nap'] ? $data['nap']['id'] : null,
        'distance' => $data['distance'],
        'gps' => strtoupper($data['gps']),
        'approved' => 0,
        'update_by' => Auth::user()->id,
        'plan_id' => $data['plan']['id'],
        'instalation_id' => $data['instalation']['id'],
        'questionnaire' => json_encode($data['questionnaire'] ? $data['questionnaire'] : null),
        'observations' => strtoupper($data['observations']),
        'num_form' => $data['num_form'],
        'mount_cash_dl' => $data['mount_cash_dl'],
        'serials_cash_dl' => $data['serials_cash_dl'],
        'mount_cash_bs' => $data['mount_cash_bs'],
        'serials_cash_bs' => $data['serials_cash_bs'],
        'mount_bank_transfer' => $data['mount_bank_transfer'],
        'serial_bank_transfer' => $data['serial_bank_transfer'],
        'mount_zelle' => $data['mount_zelle'],
        'serial_zelle' => strtoupper($data['serial_zelle']),
        'mount_movil_paid' => $data['mount_movil_paid'],
        'serial_movil_paid' => strtoupper($data['serial_movil_paid']),
        'mount_point' => $data['mount_point'],
        'serial_point' => strtoupper($data['serial_point']),
        'total_bs_received' => $data['total_bs_received'],
        'total_dls_received' => $data['total_dls_received'],
        'router' => $data['router'],
        'router_id' => $router_id,
        'router_model' => $router_name,
        'router_serial' => $data['router_serial'],
        'cable' => $data['cable'],
        'mount_cable' => $data['mount_cable'],
        'prorateo' => $data['prorateo'],
        'mount_prorateo' => $data['mount_prorateo'],
        'change_operators' => ($data['operator'] ? true : false),
        'operator_id' => ($data['operator']) ? $data['operator']['id'] : null,
        'titular_zelle' => $data['titular_zelle']
    ]);
        
        return $service;
    }

    public function approve($id, $client_id, $nro_contract){
      
        $approve =  $this->updateById($id, ['approved' => 1, 'client_id' => $client_id, 'approved_date' => Carbon::now(), 'nro_contract' => $nro_contract]);
        return $approve;
    }

    public function destroy($id){
        $request = $this->getById($id);
        $request->delete($id);
        return $request;
    }

    public function filterAllSales($search){
        $user = Auth::user();
        if($user->role_id == 1 || $user->role_id == 3 || $user->role_id == 7){
            $result= ServiceRequest::join('users', 'service_requests.seller_id', 'users.id')
                    ->join('sectors', 'service_requests.sector_id', 'sectors.id')
                    ->Where('sectors.name','LIKE',"%$search%")
                    ->orWhere('service_requests.names','LIKE',"%$search%")
                    ->orWhere('service_requests.social_razon','LIKE',"%$search%")
                    ->orWhere('service_requests.last_names','LIKE',"%$search%")
                    ->orWhere('service_requests.document','LIKE',"%$search%")
                    ->orWhere('service_requests.document2','LIKE',"%$search%")
                    ->orWhere('service_requests.celphone','LIKE',"%$search%")
                    ->orWhere('service_requests.celphone','LIKE',"%$search%")
                    ->orWhere('service_requests.created_at','LIKE',"%$search%")
                    ->orWhere('users.name','LIKE',"%$search%")
                    ->with([
                        'seller', 
                        'client', 
                        'plan', 
                        'parroquia', 
                        'sector', 
                        'nap', 
                        'instalation',
                        'contract',
                        'juridict_contract',
                        'router_model'
                        ])
                    ->Where('service_requests.approved', '=',0)
                    ->select('service_requests.*')
                    ->orderBy('service_requests.created_at','asc')->paginate(5);
            foreach($result as $key=>$nap){
                $result[$key]->parroquia = $nap->sector->parroquia;
            }
        } else if($user->role_id == 2){
            $result= ServiceRequest::join('users', 'service_requests.seller_id', 'users.id')
                ->join('sectors', 'service_requests.sector_id', 'sectors.id')
                ->Where('sectors.name','LIKE',"%$search%")
                ->orWhere('service_requests.names','LIKE',"%$search%")
                ->orWhere('service_requests.social_razon','LIKE',"%$search%")
                ->orWhere('service_requests.last_names','LIKE',"%$search%")
                ->orWhere('service_requests.document','LIKE',"%$search%")
                ->orWhere('service_requests.document2','LIKE',"%$search%")
                ->orWhere('service_requests.celphone','LIKE',"%$search%")
                ->orWhere('service_requests.celphone','LIKE',"%$search%")
                ->orWhere('service_requests.created_at','LIKE',"%$search%")
                ->orWhere('users.name','LIKE',"%$search%")
                ->with([
                'seller', 
                'client', 
                'plan', 
                'parroquia', 
                'sector', 
                'nap', 
                'instalation',
                'contract',
                'juridict_contract',
                'router_model'])
                ->where('seller_id', $user->id)
                ->Where('service_requests.approved', '=',0)
                ->select('service_requests.*')
                ->orderBy('service_requests.created_at','asc')->paginate(5);
            foreach($result as $key=>$nap){
                $result[$key]->parroquia = $nap->sector->parroquia;
            }
        }
        return $result;
    }

    public function filterSalesApproved($search){
        $user = Auth::user();
        if($user->role_id == 1 || $user->role_id == 3 || $user->role_id == 7){
            $result= ServiceRequest::join('users', 'service_requests.seller_id', 'users.id')
                ->join('sectors', 'service_requests.sector_id', 'sectors.id')
                ->Where('service_requests.approved', '=',1)
                ->Where('sectors.name','LIKE',"%$search%")
                ->orWhere('service_requests.names','LIKE',"%$search%")
                ->orWhere('service_requests.social_razon','LIKE',"%$search%")
                ->orWhere('service_requests.last_names','LIKE',"%$search%")
                ->orWhere('service_requests.document','LIKE',"%$search%")
                ->orWhere('service_requests.document2','LIKE',"%$search%")
                ->orWhere('service_requests.celphone','LIKE',"%$search%")
                ->orWhere('service_requests.celphone','LIKE',"%$search%")
                ->orWhere('service_requests.created_at','LIKE',"%$search%")
                ->orWhere('users.name','LIKE',"%$search%")
                ->with([
                    'seller', 
                    'client', 
                    'plan', 
                    'parroquia', 
                    'sector', 
                    'nap', 
                    'instalation',
                    'contract',
                    'juridict_contract',
                    'router_model'
                    ])
                ->select('service_requests.*')
                ->orderBy('service_requests.created_at','asc')->paginate(10);
            foreach($result as $key=>$nap){
                $result[$key]->parroquia = $nap->sector->parroquia;
            } 
        } else if($user->role_id == 2){
            $result= ServiceRequest::join('users', 'service_requests.seller_id', 'users.id')
                ->join('sectors', 'service_requests.sector_id', 'sectors.id')
                ->Where('sectors.name','LIKE',"%$search%")
                ->where('approved', 1)
                ->orWhere('service_requests.names','LIKE',"%$search%")
                ->orWhere('service_requests.social_razon','LIKE',"%$search%")
                ->orWhere('service_requests.last_names','LIKE',"%$search%")
                ->orWhere('service_requests.document','LIKE',"%$search%")
                ->orWhere('service_requests.document2','LIKE',"%$search%")
                ->orWhere('service_requests.celphone','LIKE',"%$search%")
                ->orWhere('service_requests.celphone','LIKE',"%$search%")
                ->orWhere('service_requests.created_at','LIKE',"%$search%")
                ->orWhere('users.name','LIKE',"%$search%")
                ->with([
                    'seller', 
                    'client', 
                    'plan', 
                    'parroquia', 
                    'sector', 
                    'nap', 
                    'instalation',
                    'contract',
                    'juridict_contract',
                    'router_model'
                    ])
                ->Where('service_requests.approved', '=',1)
                ->where('seller_id', $user->id)
                ->select('service_requests.*')
                ->orderBy('service_requests.created_at','asc')->paginate(5);
            foreach($result as $key=>$nap){
                $result[$key]->parroquia = $nap->sector->parroquia;
            }
            
        }
        $result->map(function($o){
            $router_price = ($o->router == 1) ? ItemPrice::where('id', $o->router_id)->value('price') : 0; 
            $o->invoice_total = $o->instalation->total_cost + $o->plan->price + $o->mount_cable + $o->mount_prorateo + $router_price;
            //$o->nro_contrato = (!is_null($o->contract)) ? $o->contract->nro_contract : $o->juridict_contract->nro_contract;
        });
        return $result;
    }

    public function salesReport($request){
        //$sales = $this->select();
        
        $sales = $this->with([
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

        if (($request->desde != null) && ($request->desde != null)) {
            
            $sales = $sales->whereBetween("created_at",[$request->desde, $hasta]);
            //dd($sales);
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
        $sales = $sales->paginate();
        return $sales;
    }
}
