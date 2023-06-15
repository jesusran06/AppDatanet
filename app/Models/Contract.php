<?php

namespace App\Models;

use App\Models\SubSector;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contract extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['id', 
                            'type_client', 
                            'social_razon', 
                            'document', 
                            'client_id',
                            'parroquia_id',
                            'sector_id',
                            'nap_id',
                            'plan_id',
                            'balance',
                            'balance_dls',
                            'start_contract',
                            'service_request_id',
                            'gps',
                            'active',
                            'nro',
                            'nro_contract',
                            'subsector_id',
                        ];
    
    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function parroquia()
    {
        return $this->belongsTo(Parroquia::class, 'parroquia_id', 'id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id', 'id');
    }

    public function nap()
    {
        return $this->belongsTo(Nap::class, 'nap_id', 'id');
    }

    public function service_request()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id', 'id');
    }

    static function odi($id){
        $odi = Odi::where('contract_id', $id)->first();
        return $odi;
    }

    public function subsector()
    {
        return $this->belongsTo(SubSector::class, 'subsector_id', 'id');
    }


}
