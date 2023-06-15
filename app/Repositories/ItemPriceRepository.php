<?php

namespace App\Repositories;

use App\Models\ItemPrice;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ItemPriceRepository.
 */
class ItemPriceRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return ItemPrice::class;
    }

    public function index(){
        $itemPrice = $this->all();

        return $itemPrice;
    }
}
