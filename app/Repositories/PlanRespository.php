<?php

namespace App\Repositories;

use App\Models\Plan;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use Exception;
//use Your Model

/**
 * Class PlanRespository.
 */
class PlanRespository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Plan::class;
    }

    public function getPlans(){
        $plans = $this->paginate(10);

        return $plans;
    }

    public function storePlan($data){
        try {
            $plan = $this->create($data);    
            return $plan;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }

    public function updatePlan($id, $data){
        $plan = $this->updateById($id, $data);
        return $plan;
    }

    /**
     * Delete plan function
     * return Bool
     */
    public function disable($id)
    {
        try {
            $plan = $this->deleteById($id);    
            return $plan;
        } catch (\Throwable $th) {
            return  $th;
        }
    }
    public function filter($search){
        $plans = Plan::Where('name','LIKE',"%$search%")
            ->orWhere('description','LIKE',"%$search%")
            ->orWhere('price','LIKE',"%$search%")
            ->paginate(5);

        return $plans;
    }
}
