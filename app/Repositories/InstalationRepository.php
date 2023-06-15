<?php

namespace App\Repositories;

use App\Models\Instalation;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class InstalationRepository.
 */
class InstalationRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Instalation::class;
    }

    public function getActive(){
        $instalations = $this->where('active', true)->get();
        return $instalations;
    }
}
