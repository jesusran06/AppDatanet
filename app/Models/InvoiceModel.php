<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceModel extends Model
{
    use HasFactory;
    protected $table = "invoices";
    protected $fillable = [
        'id',
        'client_id', 
        'contract_id', 
        'brute_amount', 
        'tax_amount', 
        'total_amount',
        'brute_amount_dls',
        'tax_amount_dls', 
        'total_amount_dls',
    ];

    public function client(){
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function contract(){
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
}
