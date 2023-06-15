<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Odi extends Model
{
    use HasFactory;
    protected $fillable = [
        'id', 
        'contract_id',
        'reel',
        'reel_start_mts',
        'reel_end_mts',
        'total_distance',
        'nap_port',
        'nap_potency',
        'fast_conector',            
        'pgtail',
        'strapping',
        'hoops',
        'heat_shrinkable',
        'rosettes',
        'staples',
        'client_potency',
        'return_potency',
        'onu_serial',
        'instalation_date',
        'observations',
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
        'instalator_id',
        'asignated_date',
        'update_by',
        'instalated',
        'approved',
        'approved_by',
        'approved_date',
        'total_dls_received',
        'total_bs_received'


    ];

    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function instalator(){
        return $this->belongsTo(User::class, 'instalator_id', 'id');
    }


}
