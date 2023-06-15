<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\SubSector;
use Exception;

/**
 * Class SubsectorRepository.
 */
class SubsectorRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return SubSector::class;
    }
    public function getSubSelect($id){
        $subsectors = $this->where('sector_id', $id)->get();
        return $subsectors;
    }
    public function saveSubsector($data, $id){
        try {
            $subsectors = [];
            foreach($data as $item){
                if(isset($item['id'])){
                    $item['sector_id'] = $id;
                    $resp = $this->updateById($item['id'], $item);
                    array_push($subsectors, $resp);
                } else {
                    $item['sector_id'] = $id;
                    $resp = $this->create($item);
                    array_push($subsectors, $resp);
                }
            }
            return $subsectors;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
}
