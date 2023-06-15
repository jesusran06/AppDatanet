<?php

namespace App\Repositories;

use App\Models\Operator;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class OperatorRepository.
 */
class OperatorRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Operator::class;
    }

    public function index(){
        $operators = $this->all();

        return $operators;
    }
}
