<?php

namespace App\Repositories;

use App\Models\AdditionalService;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class AdditionalServiceRepository.
 */
class AdditionalServiceRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return AdditionalService::class;
    }

    public function getAll(){
        $services = $this->all();

        return $services;
    }
}
