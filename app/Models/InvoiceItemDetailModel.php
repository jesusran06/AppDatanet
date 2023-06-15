<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItemDetailModel extends Model
{
    use HasFactory;
    protected $table = "invoice_item_detail";
    protected $fillable = [
        'invoice_id',
        'item',
        'brute_amount', 
        'tax_amount', 
        'total_amount',
        'brute_amount_dls',
        'tax_amount_dls', 
        'total_amount_dls',
    ];

    public function invoice(){
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }
}
