<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\User;
use App\Models\Client;
use App\Models\Operator;
use App\Models\ItemPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceRequest extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'service_requests';

    protected $fillable = [
        'id', 
        'type_client',
        'social_razon', 
        'document', 
        'names', 
        'last_names', 
        'document2', 
        'address', 
        'parroquia_id', 
        'sector_id',
        'subsector_id', 
        'celphone', 
        'whatsapp', 
        'email', 
        'nap_id',
        'distance',
        'gps', 
        'client_id', 
        'approved', 
        'approved_date',
        'seller_id', 
        'plan_id', 
        'instalation_id', 
        'questionnaire', 
        'observations',
        'num_form',
        'mount_cash_dl',
        'serials_cash_dl',
        'mount_cash_bs',
        'serials_cash_bs',
        'mount_bank_transfer',
        'serial_bank_transfer',
        'mount_zelle',
        'serial_zelle',
        'titular_zelle',
        'mount_movil_paid',
        'serial_movil_paid',
        'mount_point',
        'serial_point',
        'birthdate',
        'total_bs_received',
        'total_dls_received',
        'update_by',
        'router',
        'router_model',
        'router_serial',
        'cable',
        'mount_cable',
        'prorateo',
        'mount_prorateo',
        'change_operators',
        'operator_id',
        'router_id',
        'nro_contract'
    ];
    protected $dates = [
        'approved_date'
    ];

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

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

    public function instalation()
    {
        return $this->belongsTo(Instalation::class, 'instalation_id', 'id');
    }

    public function subsector()
    {
        return $this->belongsTo(SubSector::class, 'subsector_id', 'id');
    }
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'document2', 'document');
    }
    public function juridict_contract()
    {
        return $this->belongsTo(Contract::class, 'document', 'document');
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class, 'operator_id', 'id');
    }

    public function router_model()
    {
        return $this->belongsTo(ItemPrice::class, 'router_id', 'id');
    }
}
