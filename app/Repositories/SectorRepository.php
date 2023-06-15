<?php

namespace App\Repositories;

use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;
use App\Models\Sector;
use Exception;

/**
 * Class SectorRepository.
 */
class SectorRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return Sector::class;
    }
    public function getSectors(){
        $sectors = $this->with('parroquia','subsectors')->paginate(5);
        return $sectors;
    }
    public function getSelect($id){
        $sectors = $this->with('subsectors')->where('parroquia_id', $id)->get();
        return $sectors;
    }
    public function saveSector($data){
        try {
            if(isset($data['id'])){
                $sector = $this->updateById($data['id'], $data);
                
            } else {
                $sector = $this->create($data);
            }
            return $sector;
        } catch (\Throwable $th) {
            throw new Exception($th->getMessage());
        }
    }
    public function deleteSector($id)
    {
        try {
            $sector = $this->deleteById($id);
            info($sector);
            return $sector;
        } catch (\Throwable $th) {
            return  $th;
        }
    }
    public function filter($search){
        $result= Sector::join('parroquias', 'sectors.parroquia_id', 'parroquias.id')
                ->Where('sectors.name','LIKE',"%$search%")
                ->orWhere('parroquias.parroquia','LIKE',"%$search%")
                ->with('parroquia', 'subsectors')
                ->orderBy('name','desc')->paginate(5);
        return $result;
    }
}
