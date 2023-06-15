<?php

namespace App\Repositories;

use App\Models\InvoiceItemDetailModel;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class InvoiceItemDetailRepository.
 */
class InvoiceItemDetailRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return InvoiceItemDetailModel::class;
    }

    public function createSaleInvoice($data, $dls_today){
        
            $this->create([
                'invoice_id' => $data["invoice_id"],
                'item' => $data["plan"]["name"],
                'brute_amount' => $data["plan"]["price"] * $dls_today,
                'tax_amount' => 0,
                'total_amount' => $data["plan"]["price"] * $dls_today,
                'brute_amount_dls' => $data["plan"]["price"],
                'tax_amount_dls' => 0,
                'total_amount_dls' => $data["plan"]["price"],
            ]);    

            $this->create([
                'invoice_id' => $data["invoice_id"],
                'item' => $data["instalation"]["name"],
                'brute_amount' => $data["instalation"]["total_cost"] * $dls_today,
                'tax_amount' => 0,
                'total_amount' => $data["instalation"]["total_cost"] * $dls_today,
                'brute_amount_dls' => $data["instalation"]["total_cost"],
                'tax_amount_dls' => 0,
                'total_amount_dls' => $data["instalation"]["total_cost"],
            ]);
            return;    
        
        

    }
}
