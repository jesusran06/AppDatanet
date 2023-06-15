<?php

namespace App\Repositories;

use App\Models\PaidMethod;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
//use Your Model

/**
 * Class PaidMethodsRepository.
 */
class PaidMethodsRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return PaidMethod::class;
    }
}
