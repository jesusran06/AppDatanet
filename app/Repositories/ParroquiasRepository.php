<?php

namespace App\Repositories;

use App\Models\Parroquia;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class ParroquiasRepository.
 */
class ParroquiasRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Parroquia::class;
    }

    public function getIribarren(){
        $parroquias = $this->where('id_municipio', 1303)->get();

        return $parroquias;
    }
    public function getwithsectors(){
        $parroquias = $this->where('id_municipio', 1303)->with('sectors')->get();

        return $parroquias;
    }
}
