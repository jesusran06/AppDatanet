<?php

namespace App\Repositories;

use App\Models\InvoiceModel;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class InvoiceRepository.
 */
class InvoiceRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return InvoiceModel::class;
    }

    public function createSaleInvoice($data){
        $invoice = $this->create([
            'client_id' => $data["client_id"],
            'contract_id' => $data["contract_id"],
            'brute_amount' => $data["total_bs_received"],
            'tax_amount' => 0,
            'total_amount' => $data["total_bs_received"],
            'brute_amount_dls' => $data["total_dls_received"],
            'tax_amount_dls' => 0,
            'total_amount_dls' => $data["total_dls_received"],
        ]);
        return $invoice;

    }
}
